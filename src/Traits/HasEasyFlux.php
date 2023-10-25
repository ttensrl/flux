<?php
namespace TtenSrl\Flux\Traits;
use TtenSrl\Flux\Exceptions\IncorrectFluxStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Created by PhpStorm.
 * Filename: HasEasyFlux.php
 * User: Stefano Pimpolari
 * Email: spimpolari@gmail.com
 * Project: laravel-bricks-bootstrap5
 * Date: 28/12/21
 * Time: 10:16
 * MIT License
 *
 * Copyright (c) [2021] [laravel-bricks-bootstrap5]
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
trait HasEasyFlux
{
    /**
     * Boot Trait
     */
    public static function bootHasEasyFlux()
    {
        /**
         * Quando viene creato un record il campo status viene impostato su bozza
         */
        static::creating(function ($model) {
            $status_column = config('bricks-flux.column');
            $model->{$status_column} = config('bricks-flux.status.draft');
        });
    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getTransStatusAttribute()
    {
        return trans('bricks-flux::flux.status.'.array_keys(config('bricks-flux.status'),$this->status)[0]);
    }

    /**
     * Astrazione per la get del campo status
     *
     * @return mixed
     */
    public function getStatusAttribute($value)
    {
        $status_column = config('bricks-flux.column');
        if($status_column != 'status') {
            return $this->{$status_column};
        } else {
            return $value;
        }
    }

    /**
     * Astrazione per la set del campo status
     *
     * @param $value
     */
    public function setStatusAttribute($value)
    {
        $status_column = config('bricks-flux.column');
        $this->attributes[$status_column] = $value;
    }

    /**
     * Imposta il record nello stato pubblicato
     *
     * @return bool
     */
    public function publish()
    {
        if($this->status !== config('bricks-flux.status.published') ) {
            $status_column          = config('bricks-flux.column');
            $this->{$status_column} = config('bricks-flux.status.published');
            if(config('bricks-flux.publication_date.active') && config('bricks-flux.publication_date.auto_save_on_published')) {
                $published_column = config('bricks-flux.publication_date.column');
                $this->{$published_column} = Carbon::now();
            }
        } else {
            throw IncorrectFluxStatus::create(config('bricks-flux.status.published'), $this->status);
        }
        return $this->save();
    }

    /**
     * Imposta il record nello stato Non Pubblicato
     *
     * @return bool
     */
    public function unPublish()
    {
        if($this->status === config('bricks-flux.status.published') ) {
            $status_column          = config('bricks-flux.column');
            $this->{$status_column} = config('bricks-flux.status.unpublished');
        } else {
            throw IncorrectFluxStatus::create(config('bricks-flux.status.unpublished'), $this->status);
        }
        return $this->save();
    }

    /**
     * Imposta il record nello stato pubblicato se non lo è e nello stato non pubblicato se è pubblicato
     *
     * @return bool|void
     */
    public function togglePublishing()
    {
        if($this->status !== config('bricks-flux.status.published') ) {
            return $this->publish();
        } elseif($this->status === config('bricks-flux.status.published')) {
            return $this->unPublish();
        }
    }

    /**
     * Ottiene solo i record nello stato Bozza
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->where(config('bricks-flux.column'), config('bricks-flux.status.draft'));
    }

    /**
     * Ottiene solo i record nello stato pubblicato
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where(config('bricks-flux.column'), config('bricks-flux.status.published'))->where(function(\Illuminate\Database\Eloquent\Builder $query){
            if(config('bricks-flux.publication_date.active')) {
                $query->where(config('bricks-flux.publication_date.column'), '<=', Carbon::now()->toDateTimeString());
            }
        });
    }

    /**
     * Ottiene solo i record nello stato non pubblicato
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnPublished(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where(config('bricks-flux.column'), config('bricks-flux.status.unpublished'));
    }

    /**
     * Ottien solo i record che non sono pubblicati
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPublished(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where(function(\Illuminate\Database\Eloquent\Builder $query) {
            $query->where(config('bricks-flux.column'), config('bricks-flux.status.unpublished'))->orWhere(config('bricks-flux.column'), config('bricks-flux.status.draft'));
            if(config('bricks-flux.publication_date.active')) {
                $query->orWhere(config('bricks-flux.publication_date.column'), '>=', Carbon::now()->toDateTimeString());
            }
        });
    }
}

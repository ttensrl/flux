<?php
/**
 * Created by PhpStorm.
 * Filename: FluxStatus.php
 * User: Stefano Pimpolari
 * Email: spimpolari@gmail.com
 * Project: laravel-bricks-bootstrap5
 * Date: 27/12/21
 * Time: 15:47
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
namespace TtenSrl\Flux\Http\Livewire;

use TtenSrl\Flux\Classes\Flowable;
use TtenSrl\Flux\Facades\Capacitor;
use Livewire\Component;

class FluxStatus extends Component
{
    /**
     * @var Flowable Oggetto del modello che ha gli stati
     */
    public Flowable $flowable;

    /**
     * @var string
     */
    public string $template;

    public function mount($template = 'bricks-flux::livewire.flux')
    {
        $this->template = $template;
    }

    /**
     * @param  string  $status lo stato da cambiare
     */
    public function toggle(string $status)
    {
        Capacitor::fluxing($this->flowable, $status);
    }

    /**
     * Render della vista Livewire
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view($this->template);
    }
}

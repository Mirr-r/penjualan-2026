<?php

namespace App\Livewire;

use Livewire\Component;

class KeranjangPage extends Component
{
    public array $keranjang = [];

    public function mount(): void
    {
        $this->keranjang = session()->get('keranjang', []);
    }

    public function tambahQty($id): void
    {
        if (isset($this->keranjang[$id])) {
            $this->keranjang[$id]['qty']++;
        }

        session()->put('keranjang', $this->keranjang);
    }

    public function kurangQty($id): void
    {
        if (isset($this->keranjang[$id])) {
            if ($this->keranjang[$id]['qty'] > 1) {
                $this->keranjang[$id]['qty']--;
            } else {
                unset($this->keranjang[$id]);
            }
        }

        session()->put('keranjang', $this->keranjang);
    }

    public function hapusItem($id): void
    {
        unset($this->keranjang[$id]);

        session()->put('keranjang', $this->keranjang);
    }

    public function kosongkan(): void
    {
        $this->keranjang = [];

        session()->forget('keranjang');
    }

    public function getTotalProperty()
    {
        return collect($this->keranjang)
            ->sum(fn ($item) => $item['harga'] * $item['qty']);
    }

    public function render()
    {
        return view('livewire.keranjang-page');
    }
}
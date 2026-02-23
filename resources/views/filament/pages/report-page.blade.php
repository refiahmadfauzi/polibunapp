<x-filament-panels::page>
    <div>
        {{-- Tab Navigation --}}
        <div class="flex gap-2 mb-6">
            <x-filament::button
                :color="$activeTab === 'per_medis' ? 'primary' : 'gray'"
                wire:click="$set('activeTab', 'per_medis')"
                size="sm"
            >
                Per Tenaga Medis
            </x-filament::button>
            <x-filament::button
                :color="$activeTab === 'per_metode' ? 'primary' : 'gray'"
                wire:click="$set('activeTab', 'per_metode')"
                size="sm"
            >
                Per Metode Pembayaran
            </x-filament::button>
            <x-filament::button
                :color="$activeTab === 'margin' ? 'primary' : 'gray'"
                wire:click="$set('activeTab', 'margin')"
                size="sm"
            >
                Margin Pembelian
            </x-filament::button>
            <x-filament::button
                :color="$activeTab === 'batal' ? 'primary' : 'gray'"
                wire:click="$set('activeTab', 'batal')"
                size="sm"
            >
                Transaksi Batal
            </x-filament::button>
        </div>

        {{-- Table --}}
        {{ $this->table }}
    </div>
</x-filament-panels::page>

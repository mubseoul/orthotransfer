<div class="card max-w-md mx-auto">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Stack Demo</h2>
    
    <!-- Livewire Counter -->
    <div class="form-group">
        <label class="form-label">Livewire Counter (Server-side reactive)</label>
        <div class="flex items-center gap-4">
            <button wire:click="decrement" class="btn-primary">-</button>
            <span class="text-2xl font-bold text-gray-700">{{ $count }}</span>
            <button wire:click="increment" class="btn-primary">+</button>
        </div>
    </div>

    <!-- Alpine.js Counter -->
    <div class="form-group" x-data="{ alpineCount: 0 }">
        <label class="form-label">Alpine.js Counter (Client-side reactive)</label>
        <div class="flex items-center gap-4">
            <button @click="alpineCount--" class="bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">-</button>
            <span class="text-2xl font-bold text-gray-700" x-text="alpineCount"></span>
            <button @click="alpineCount++" class="bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">+</button>
        </div>
    </div>

    <!-- Tailwind Styled Form -->
    <div class="form-group">
        <label class="form-label">Tailwind Styled Input</label>
        <input type="text" class="form-input" placeholder="Type something..." x-data x-model="$el.value">
    </div>
</div>

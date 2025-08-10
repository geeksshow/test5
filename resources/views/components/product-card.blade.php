<div class="w-full md:w-1/2 lg:w-1/4 p-2">
    <div
        class="bg-white rounded-2xl overflow-hidden shadow-xl transition-all duration-500 ease-[cubic-bezier(0.175,0.885,0.32,1.275)] hover:shadow-2xl hover:-translate-y-4 hover:scale-[1.03] cursor-pointer"
    >
        <div class="relative h-64 bg-gradient-to-br from-slate-100 to-slate-300 flex items-center justify-center overflow-hidden">
            <img
                src="{{ $image ?? 'photos/p1.png' }}"
                alt="{{ $title ?? 'Product Image' }}"
                class="w-4/5 h-4/5 object-contain transition-transform duration-500 ease-[cubic-bezier(0.175,0.885,0.32,1.275)] hover:scale-110 hover:-rotate-2"
            />
        </div>

        <div class="p-4">
            <span class="inline-block bg-gray-100 text-xs text-gray-800 px-3 py-1 rounded-full uppercase tracking-wide mb-2">
                {{ $category ?? 'Category' }}
            </span>
            <h5 class="text-md font-semibold mb-3 leading-snug">
                {{ $title ?? 'Product Title' }}
            </h5>
            <div class="mb-4">
                <span class="text-lg font-bold text-gray-900">{{ $price ?? 'Rs. 0.00' }}</span>
            </div>
            <button class="w-full bg-black text-white font-semibold py-2 rounded-md hover:bg-gray-800 transition">
                <i class="bi bi-cart3 mr-2"></i>Add to Cart
            </button>
        </div>
    </div>
</div>

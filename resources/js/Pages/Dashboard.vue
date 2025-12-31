<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    products: Array,
    carts: Array
});

const page = usePage();

const addToCart = (product) => {
    const existingItem = props.carts.find(item => item.product_id === product.id);
    const quantity = existingItem ? existingItem.quantity + 1 : 1;

    router.post('/cart/update', {
        user_id: page.props.auth.user.id,
        product_id: product.id,
        quantity: quantity
    }, {
        preserveState: true,
        preserveScroll: true,
        only: ['carts']
    });
};

const removeFromCart = (productId) => {
    router.post('/cart/delete', {
        user_id: page.props.auth.user.id,
        product_id: productId
    }, {
        preserveState: true,
        preserveScroll: true,
        only: ['carts']
    });
};

const updateQuantity = (item, newQuantity) => {
    const quantity = parseInt(newQuantity);
    if (quantity > 0) {
        router.post('/cart/update', {
            user_id: page.props.auth.user.id,
            product_id: item.product_id,
            quantity: quantity
        }, {
            preserveState: true,
            preserveScroll: true,
            only: ['carts']
        });
    } else {
        removeFromCart(item.product_id);
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Products Table -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Products</h3>
                                <table class="min-w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border border-gray-300 px-4 py-2 text-left">Product Name</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Stock Quantity</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-2">{{ product.name }}</td>
                                            <td class="border border-gray-300 px-4 py-2">${{ product.price }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ product.stock_quantity }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <button
                                                    @click="addToCart(product)"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                                >
                                                    Add to Cart
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Cart Table -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Cart</h3>
                                <table class="min-w-full border-collapse border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border border-gray-300 px-4 py-2 text-left">Product Name</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Quantity</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="carts.length === 0">
                                            <td colspan="3" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                                Your cart is empty
                                            </td>
                                        </tr>
                                        <tr v-for="item in carts" :key="item.product_id" class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-2">{{ item.name }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input
                                                    type="number"
                                                    :value="item.quantity"
                                                    @input="updateQuantity(item, $event.target.value)"
                                                    min="1"
                                                    class="w-20 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                />
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <button
                                                    @click="removeFromCart(item.product_id)"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

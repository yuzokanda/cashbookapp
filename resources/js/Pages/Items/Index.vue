<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { computed } from 'vue';

const props = defineProps({
    items: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({});

const day = new Date();


const amountTotal = computed(() => {
    return props.items.reduce((sum, item) => sum + (item.amount || 0), 0);
});

function destroy(id) {
    if (confirm("Are you sure you want to Delete?")) {
        form.delete(route("items.destroy", id));
    }
}

</script>

<template>
    <Head title="items" />

    <AuthenticatedLayout>
        <template #header>
            <div class="text-xm font-semibold uppercase leading-tight text-gray-800">
                Index
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- flex justify-between ...を使いADD ITEMボタンと現在日時表示を左右両端に分ける -->
                        <div class="flex justify-between ... mb-2">
                            <div class="px-2">
                                <Link :href="route('items.create')">
                                <PrimaryButton class="bg-green-700">Add Item</PrimaryButton>
                                </Link>
                            </div>
                            <div class="px-2 py-2 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                <!-- 現在日時表示とメソッドの切り分け修正予定 -->
                                支出合計 ¥ {{ amountTotal.toLocaleString() }} ({{ day.toLocaleDateString() }}現在)
                            </div>
                        </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Content
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Amount
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="item in items" :key="item.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                                {{ item.id }}
                                            </th>
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                                {{ item.content }}
                                            </th>
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                                ¥ {{ item.amount.toLocaleString() }}
                                            </th>
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                                {{ item.category }}
                                            </th>
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                                {{ item.date }}
                                            </th>
                                            <td class="px-6 py-4">
                                                <Link :href="route('items.edit', item.id)
                                                    " class="px-4 py-2 text-white bg-blue-600 rounded-lg">Edit</Link>
                                            </td>
                                            <td class="px-6 py-4">
                                                <PrimaryButton class="bg-red-700" @click="destroy(item.id)">
                                                    Delete
                                                </PrimaryButton>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

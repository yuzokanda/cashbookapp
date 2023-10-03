<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


let items = ref([]);
let month = ("0"+(new Date().getMonth() + 1)).slice(-2)
// 現在の年と月を初期値に設定
let selectedPeriod = ref(`${new Date().getFullYear()}-${month}`);
// 過去12ヶ月分の年と月の組み合わせを選択肢に設定
let periods = Array.from({length: 12}, (_, i) => {
    const date = new Date();
    date.setMonth(date.getMonth() - i);
    return `${date.getFullYear()}-${("0"+(date.getMonth() + 1)).slice(-2)}`;
});

const form = useForm({});
// 支出日降順にソート
const sortedItems = computed(() => {
    return items.value.sort((a, b) => new Date(b.date) - new Date(a.date));
});
// 支出合計金額を算出
const amountTotal = computed(() => {
    return items.value.reduce((sum, item) => sum + (item.amount || 0), 0);
});

// 選択月のitemsをfetch apiにより非同期にDBよりjson形式にて取得
const fetchData = async () => {
    const response = await fetch(`/data/${selectedPeriod.value}`);
    items.value = await response.json();
};
// DOMへのマウント直後にfetchDataを実行
onMounted(fetchData);

function destroy(id) {
    if (confirm("Are you sure you want to Delete?")) {
        form.delete(route("items.destroy", id));
    }
}
</script>

<template>
    <Head title="DATA" />

    <AuthenticatedLayout>
        <template #header>
            <div class="text-xm font-semibold uppercase leading-tight text-gray-800">
                data
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between ... mb-2">
                            <div class="px-2">
                                <Link :href="route('items.create')">
                                <PrimaryButton class="bg-green-700">Add Item</PrimaryButton>
                                </Link>
                            </div>
                            <div class="px-2 py-2 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                <!-- 現在日時表示とメソッドの切り分け修正予定 -->
                                {{ selectedPeriod }}月支出合計 ¥ {{ amountTotal.toLocaleString() }}
                            </div>
                            <div class="px-2">
                            <div>
                                <select v-model="selectedPeriod" @change="fetchData">
                                    <option v-for="period in periods" :key="period" :value="period">{{ period }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <!-- <th scope="col" class="px-6 py-3">#</th> -->
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
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="item in sortedItems" :key="item.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <!-- <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white  whitespace-nowrap">
                                                {{ item.id }}
                                            </th> -->
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

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, onMounted, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { useStore } from 'vuex';

const props = defineProps({
    periods: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({});

const store = useStore();

let items = ref([]);

let selectedPeriod = ref(store.state.selectedPeriod || props.periods[0]);

// computedにより値が変化した場合のみ選択処理された年月を年と月に分離し代入
const parts = computed(() => {
    return selectedPeriod.value.split('-');
});
// computedにより値が変化した場合のみ分離処理した年を代入
const selectYear = computed(() => {
    return parts.value[0];
});
// computedにより値が変化した場合のみ分離処理された月を代入
const selectMonth = computed(() => {
    return parseInt(parts.value[1]);
});
// computedにより値が変化した場合のみ日本語形式(⚪︎年⚪︎月)に処理された値を代入
const formattedPeriod = computed(() => {
    return `${selectYear.value}年${selectMonth.value}月`;
});

// 支出日降順にソート
const sortedItems = computed(() => {
    return items.value.sort((a, b) => new Date(b.date) - new Date(a.date));
});
// 支出合計金額を算出
const amountTotal = computed(() => {
    return items.value.reduce((sum, item) => sum + (item.amount || 0), 0);
});
// try,catchのエラー処理をしつつ、fetch apiにより非同期に選択月のitems取得
const fetchData = async () => {
    try {
        const response = await fetch(`/items/${store.state.selectedPeriod}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        items.value = await response.json();
    } catch (error) {
        console.error('An error occurred while fetching the data: ', error);
    }
};
console.log(store.state.selectedPeriod);
console.log('↑store.state');
console.log(props.periods[0]);

// DOMマウント直後にif条件分岐でfetchData()を実行
onMounted(() => {
    if (!store.state.selectedPeriod) {
    store.dispatch('updateSelectedPeriod', props.periods[0]);
    }
    fetchData();
});
// 年月の再選択によりselectedPeriodのstate変更
const changePeriod = async (period) => {
    await store.dispatch('updateSelectedPeriod', period);
    fetchData();
};

const deleteItem = (id) => {
    if (confirm("本当に削除しますか？")) {
        form.delete(route("items.destroy", id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => fetchData(),
        });
    };
};
</script>

<template>
    <Head title="items" />

    <AuthenticatedLayout>
        <template #header>
            <div class="text-xm font-semibold uppercase leading-tight text-gray-800">
                ITEMS
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
                                {{ formattedPeriod }}支出合計 ¥ {{ amountTotal.toLocaleString() }}
                            </div>
                            <div class="px-2">
                            <div>
                                <select v-model.lazy="selectedPeriod" @change="changePeriod(selectedPeriod)">
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
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
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
                                                <Link :href="route('items.edit', item.id)" class="px-4 py-2 text-white bg-blue-600 rounded-lg">Edit</Link>
                                            </td>
                                            <td class="px-6 py-4">
                                                <PrimaryButton class="bg-red-700" @click="deleteItem(item.id)">
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

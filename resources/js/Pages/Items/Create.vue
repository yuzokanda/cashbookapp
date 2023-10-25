<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import { useStore } from 'vuex';

const props = defineProps({
    category_id: {
        type: Object,
        default: () => ({}),
    },
});

const store = useStore();

const form = reactive(useForm({
    content: "",
    amount: "",
    category_id: "",
    date: "",
}));

let selectedPeriod = ref(store.state.selectedPeriod);

let isSubmitting = false;
const submit = () => {
    isSubmitting = true;
    form.post(route('items.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            store.dispatch('updateSelectedPeriod', selectedPeriod.value);
            form.reset();
            isSubmitting = false;
        },
    });
};

</script>

<template>
    <Head title="ITEM CREATE" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xm uppercase text-gray-800 leading-tight">Item Create</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-3xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg flex justify-center ...">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="content" value="content" />

                                <TextInput
                                    id="content"
                                    type="text"
                                    class="mt-1 block w-96"
                                    v-model="form.content"
                                    required
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.content"
                                />
                            </div>
                            <div>
                                <InputLabel for="amount" value="amount" />

                                <TextInput
                                    id="amount"
                                    type="number"
                                    class="mt-1 block w-32"
                                    v-model="form.amount"
                                    required
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.amount"
                                />
                            </div>
                            <div>
                                <InputLabel for="category_id" value="category" />

                                <select id="category_id" class="mt-1 block w-40" v-model="form.category_id" required>
                                    <option v-for="category in category_id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.category"
                                />
                            </div>
                            <div>
                                <InputLabel for="date" value="date" />

                                <TextInput
                                    id="date"
                                    type="date"
                                    class="mt-1 block w-40"
                                    v-model="form.date"
                                    required
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.date"
                                />
                            </div>

                        <div class="flex gap-4">
                            <div>
                            <PrimaryButton
                                type="submit"
                                class="mt-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing || isSubmitting"
                                @click="submit"
                            >
                                Add
                            </PrimaryButton>
                            </div>
                            <!-- Indexページに戻るボタン追加 -->
                            <div>
                            <Link :href="route('items.index')">
                                <PrimaryButton class="mt-4 bg-violet-700">Return</PrimaryButton>
                            </Link>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

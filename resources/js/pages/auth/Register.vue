<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    title: '',
    name: '',
    email: '',
    first_line: '',
    second_line: '',
    town: '',
    city: '',
    county: '',
    country: '',
    post_code: '',
    full_time: false,
    part_time: false,
    role_id: '',
    department_id: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthBase title="Create an account" description="Enter your details below to create your account">
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-4">
                <!-- Personal Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <Label for="title">Title</Label>
                        <Input id="title" v-model="form.title" placeholder="Mr, Mrs, Miss, Ms, Dr" />
                        <InputError :message="form.errors.title" />
                    </div>
                    <div>
                        <Label for="name">Full Name</Label>
                        <Input id="name" required v-model="form.name" />
                        <InputError :message="form.errors.name" />
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <Label for="email">Email address</Label>
                    <Input id="email" type="email" required v-model="form.email" />
                    <InputError :message="form.errors.email" />
                </div>

                <!-- Address -->
                <div class="grid gap-2">
                    <Label for="first_line">Address Line 1</Label>
                    <Input id="first_line" required v-model="form.first_line" />
                    <InputError :message="form.errors.first_line" />
                </div>
                <div class="grid gap-2">
                    <Label for="second_line">Address Line 2</Label>
                    <Input id="second_line" v-model="form.second_line" />
                    <InputError :message="form.errors.second_line" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <Label for="town">Town</Label>
                        <Input id="town" v-model="form.town" />
                        <InputError :message="form.errors.town" />
                    </div>
                    <div>
                        <Label for="city">City</Label>
                        <Input id="city" v-model="form.city" />
                        <InputError :message="form.errors.city" />
                    </div>
                    <div>
                        <Label for="county">County</Label>
                        <Input id="county" v-model="form.county" />
                        <InputError :message="form.errors.county" />
                    </div>
                    <div>
                        <Label for="country">Country</Label>
                        <Input id="country" v-model="form.country" />
                        <InputError :message="form.errors.country" />
                    </div>
                </div>
                <div>
                    <Label for="post_code">Post Code</Label>
                    <Input id="post_code" v-model="form.post_code" />
                    <InputError :message="form.errors.post_code" />
                </div>

                <!-- Employment Status -->
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" v-model="form.full_time" />
                        <span class="ml-2">Full Time</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" v-model="form.part_time" />
                        <span class="ml-2">Part Time</span>
                    </label>
                </div>

                <!-- Role and Department -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <Label for="role_id">Role</Label>
                        <Input id="role_id" v-model="form.role_id" placeholder="Role ID" />
                        <InputError :message="form.errors.role_id" />
                    </div>
                    <div>
                        <Label for="department_id">Department</Label>
                        <Input id="department_id" v-model="form.department_id" placeholder="Department ID" />
                        <InputError :message="form.errors.department_id" />
                    </div>
                </div>

                <!-- Passwords -->
                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input id="password" type="password" required v-model="form.password" />
                    <InputError :message="form.errors.password" />
                </div>
                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input id="password_confirmation" type="password" required v-model="form.password_confirmation" />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink :href="route('login')" class="underline underline-offset-4">Log in</TextLink>
            </div>
        </form>
    </AuthBase>
</template>

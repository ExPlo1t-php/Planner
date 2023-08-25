<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Module from '@/Components/Module.vue'
import { Head, Link, usePage} from '@inertiajs/vue3';
import { computed } from 'vue'
const { props } = usePage();
const role = props.auth.user.role
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
    <div class="my-6 max-w-7xl m-auto">
        <div v-if="$page.props.flash.message" class="bg-red-100 border border-red-400 text-red-700 w-1/2 self-center px-4 py-3 m-auto rounded relative" role="alert">
            <strong class="font-bold">{{ $page.props.flash.message }}!</strong>
        </div>

        <section class="bg-white dark:bg-gray-900">
            <h2 class="mx-6 text-3xl tracking-tight font-bold text-gray-900 dark:text-white flex items-center">
                <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-4">
                    <rect width="24" height="24" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 9.5C5 7.01472 7.01472 5 9.5 5C11.9853 5 14 7.01472 14 9.5C14 11.9853 11.9853 14 9.5 14C7.01472 14 5 11.9853 5 9.5Z" fill="#323232"/>
                    <path d="M14.3675 12.0632C14.322 12.1494 14.3413 12.2569 14.4196 12.3149C15.0012 12.7454 15.7209 13 16.5 13C18.433 13 20 11.433 20 9.5C20 7.567 18.433 6 16.5 6C15.7209 6 15.0012 6.2546 14.4196 6.68513C14.3413 6.74313 14.322 6.85058 14.3675 6.93679C14.7714 7.70219 15 8.5744 15 9.5C15 10.4256 14.7714 11.2978 14.3675 12.0632Z" fill="#323232"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.64115 15.6993C5.87351 15.1644 7.49045 15 9.49995 15C11.5112 15 13.1293 15.1647 14.3621 15.7008C15.705 16.2847 16.5212 17.2793 16.949 18.6836C17.1495 19.3418 16.6551 20 15.9738 20H3.02801C2.34589 20 1.85045 19.3408 2.05157 18.6814C2.47994 17.2769 3.29738 16.2826 4.64115 15.6993Z" fill="#323232"/>
                    <path d="M14.8185 14.0364C14.4045 14.0621 14.3802 14.6183 14.7606 14.7837V14.7837C15.803 15.237 16.5879 15.9043 17.1508 16.756C17.6127 17.4549 18.33 18 19.1677 18H20.9483C21.6555 18 22.1715 17.2973 21.9227 16.6108C21.9084 16.5713 21.8935 16.5321 21.8781 16.4932C21.5357 15.6286 20.9488 14.9921 20.0798 14.5864C19.2639 14.2055 18.2425 14.0483 17.0392 14.0008L17.0194 14H16.9997C16.2909 14 15.5506 13.9909 14.8185 14.0364Z" fill="#323232"/>
                </svg>
                Gestion Des Employés
            </h2>
            <div class="grid lg:grid-cols-4 md:grid-cols-3 gap-2">
                <Module link="employees.index">
                    Gestion des Employés
                </Module>
                <Module link="teams.index">
                    Gestion des Teams
                </Module>
                <Module link="employees.show_absences">
                    Gestion des Absences
                </Module>
            </div>
        </section>
        <section class="bg-white dark:bg-gray-900">
            <h2 class="mx-6 text-3xl tracking-tight font-bold text-gray-900 dark:text-white flex items-center">
                <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-4">
                    <path d="M5 6V15.8C5 16.9201 5 17.4802 5.21799 17.908C5.40973 18.2843 5.71569 18.5903 6.09202 18.782C6.51984 19 7.07989 19 8.2 19H15.8C16.9201 19 17.4802 19 17.908 18.782C18.2843 18.5903 18.5903 18.2843 18.782 17.908C19 17.4802 19 16.9201 19 15.8V6M5 6C5 6 5 3 12 3C19 3 19 6 19 6M5 6H19M5 13H19M17 21V19M7 21V19M8 16H8.01M16 16H16.01" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Transport
            </h2>
            <div class="grid lg:grid-cols-4 md:grid-cols-3">
                <Module link="vehicles.index">
                    Gestion des Vehicules 
                </Module>
                <Module link="drivers.index">
                    Gestion des Chauffeurs 
                </Module>
                <Module link="terminals.index"> 
                    Gestion des Terminals (Paradas)
                </Module>
            </div>
        </section>
        <section class="bg-white dark:bg-gray-900">
            <h2 class="mx-6 text-3xl tracking-tight font-bold text-gray-900 dark:text-white flex items-center">
                <svg fill="#000000" width="40px" height="40px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" class="mr-4">
                    <path d="m773.596 1069.654 711.086 711.085c39.632 39.632 104.336 39.632 144.078 0l138.276-138.385c19.268-19.269 29.888-44.778 29.888-71.93 0-27.26-10.62-52.77-29.888-72.039l-698.714-698.714 11.495-32.625c63.5-178.675 18.284-380.45-115.284-514.018-123.715-123.605-305.126-171.01-471.648-128.313l272.281 272.282c32.516 32.406 50.362 75.652 50.362 121.744 0 45.982-17.846 89.227-50.362 121.744L654.48 751.17c-67.222 67.003-176.375 67.003-243.488 0L138.711 478.889c-42.589 166.522 4.707 347.934 128.313 471.648 123.714 123.715 306.22 172.325 476.027 127.218l30.545-8.101ZM1556.611 1920c-54.084 0-108.168-20.692-149.333-61.857L740.095 1190.96c-198.162 41.712-406.725-19.269-550.475-163.019C14.449 852.771-35.256 582.788 65.796 356.27l32.406-72.696 390.194 390.193c24.414 24.305 64.266 24.305 88.68 0l110.687-110.686c11.824-11.934 18.283-27.59 18.283-44.34 0-16.751-6.46-32.516-18.283-44.34L297.569 84.207 370.265 51.8C596.893-49.252 866.875.453 1041.937 175.515c155.026 155.136 212.833 385.157 151.851 594.815l650.651 650.651c39.961 39.852 61.967 92.95 61.967 149.443 0 56.383-22.006 109.482-61.967 149.334l-138.275 138.385c-41.275 41.165-95.36 61.857-149.553 61.857Z" fill-rule="evenodd"/>
                </svg>
                Admin
            </h2>
            <div class="grid lg:grid-cols-4 md:grid-cols-3">
                <Module v-if="role=='administrator'" link="users.index"> 
                    Gestion des Utilisateurs
                </Module>
                <Module link="projects.index">
                    Gestion des Projets
                </Module>
                <Module link="positions.index">
                    Gestion des positions
                </Module>
                <Module link="stations.index">
                    Gestion des Stations
                </Module>
                <Module link="departments.index">
                    Gestion des Departments
                </Module>
            </div>
        </section>
    </div>        
</AuthenticatedLayout>
</template>

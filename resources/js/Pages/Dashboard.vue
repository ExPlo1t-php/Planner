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
            <h2 class="mx-6 text-3xl tracking-tight font-bold text-gray-900 dark:text-white">Ressources humaines</h2>
            <div class="grid lg:grid-cols-4 md:grid-cols-3 gap-2">
                <Module link="teams.index">
                    Gestion des Teams
                </Module>
                <Module link="employees.index">
                    Gestion des Employés
                </Module>
                <Module link="employees.show_absences">
                    Gestion des Absences
                </Module>
            </div>
        </section>
        <section class="bg-white dark:bg-gray-900">
            <h2 class="mx-6 text-3xl tracking-tight font-bold text-gray-900 dark:text-white">Transport</h2>
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
            <h2 class="mx-6 text-3xl tracking-tight font-bold text-gray-900 dark:text-white">Admin</h2>
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

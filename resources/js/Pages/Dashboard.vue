<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Module from '@/Components/Module.vue'
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
    <div class="my-6">
        <section class="bg-white dark:bg-gray-900">
            <h2 class="mx-6 text-3xl tracking-tight font-bold text-gray-900 dark:text-white">Transport</h2>
            <div class="flex">
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
            <h2 class="mx-6 text-3xl tracking-tight font-bold text-gray-900 dark:text-white">Ressources humaines</h2>
            <div class="grid grid-cols-3">
                <Module link="users.index"> 
                    Gestion des Utilisateurs
                </Module>
                <Module link="projects.index">
                    Gestion des Projets
                </Module>
                <Module link="positions.index">
                    Gestion des Postes
                </Module>
                <Module link="teams.index">
                    Gestion des Teams
                </Module>
                <Module link="stations.index">
                    Gestion des Stations
                </Module>
                <Module link="departments.index">
                    Gestion des Departments
                </Module>
                <Module link="employees.index">
                    Gestion des Employés
                </Module>
            </div>
            </section>
    </div>        
</AuthenticatedLayout>
</template>

<Modal :modalId="user.name+user.id">
    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour l'utilisateur {{ user.name }}</h3>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="name" value="Name" />

            <TextInput
                id="nameUpdate"
                type="text"
                class="mt-1 block w-full"
                v-model="user.id"
                required
                autofocus
                autocomplete="name"
            />

            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div>
            <InputLabel for="role" value="Role" />

            <SelectInput
                id="roleUpdate"
                class="mt-1 block w-full"
                v-model="form.role"
                required
                autofocus
            >
                <option value="administrator">Administrateur</option>
                <option value="assembly_editor">Éditeur d'assemblage</option>
                <option value="injection_editor">Éditeur d'injection </option>
                <option value="administration_editor">Éditeur d'administration </option>
            </SelectInput>

            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div class="mt-4">
            <InputLabel for="email" value="Email" />

            <TextInput
                id="emailUpdate"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
            />

            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="Password" />

            <TextInput
                id="passwordUpdate"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autocomplete="new-password"
            />

            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel for="password_confirmation" value="Confirm Password" />

            <TextInput
                id="password_confirmationUpdate"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                required
                autocomplete="new-password"
            />

            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>
        
        <button type="submit" class="w-full text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
    </form>
</Modal>
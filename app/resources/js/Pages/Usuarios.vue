<template>
  <Head title="Usuários" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">👥 Lista de Usuários</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Email Verificado</th>
                  <th>Criado em</th>
                  <th>Atualizado em</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="usuario in usuarios" :key="usuario.id">
                  <td>{{ usuario.name }}</td>
                  <td>{{ usuario.email }}</td>
                  <td>{{ usuario.email_verified_at ? formatarData(usuario.email_verified_at) : '❌ Não Verificado' }}</td>
                  <td>{{ formatarData(usuario.created_at) }}</td>
                  <td>{{ formatarData(usuario.updated_at) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Head } from '@inertiajs/vue3';

const usuarios = ref([]);

const fetchUsuarios = async () => {
  try {
    const response = await axios.get('/api/users');
    usuarios.value = response.data;
  } catch (error) {
    console.error('Erro ao buscar usuários:', error);
  }
};

const formatarData = (dataISO) => {
  const data = new Date(dataISO);
  return data.toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

onMounted(fetchUsuarios);
</script>

<style scoped>
.table-container {
  max-width: 900px;
  margin: 40px auto;
  padding: 20px;
}

.table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

th, td {
  padding: 12px;
  border: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: #f5f5f5;
  color: #555;
}

td {
  color: #333;
}
</style>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
defineProps({ logs: Array });
</script>

<template>
  <Head title="Logs de Produtos" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">📋 Logs de Produtos</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Produto</th>
                  <th>Usuário</th>
                  <th>Ação</th>
                  <th>Data</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="log in logs" :key="log.id">
                  <td>{{ log.id }}</td>
                  <td>{{ log.product_title }}</td>
                  <td>{{ log.user_name }}</td>
                  <td>{{ log.acao }}</td>
                  <td>{{ log.data }}</td>
                </tr>
              </tbody>
            </table>
            <div v-if="logs.length === 0">Nenhum log encontrado.</div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 12px;
  border-bottom: 1px solid #e5e7eb;
  text-align: left;
}
</style>
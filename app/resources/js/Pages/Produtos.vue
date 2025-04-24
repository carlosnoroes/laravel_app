<template>
  <Head title="Produtos" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">📦 Lista de Produtos</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>Imagem</th>
                  <th>Título</th>
                  <th>Preço de Venda</th>
                  <th>Preço de Custo</th>
                  <th>Status</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="produto in produtos" :key="produto.id">
                  <td>
                    <div v-if="produto.image">
                      <img
                        v-for="(img, idx) in getImagens(produto.image)"
                        :key="idx"
                        :src="`/storage/${img}`"
                        alt="Imagem"
                        class="miniatura"
                      />
                    </div>
                  </td>
                  <td>{{ produto.title }}</td>
                  <td>R$ {{ produto.price_sale }}</td>
                  <td>R$ {{ produto.price_cost }}</td>
                  <td>{{ produto.active ? 'Ativo' : 'Inativo' }}</td>
                  <td class="acoes">
                    <button class="btn btn-editar" @click="editarProduto(produto.id)">
                      ✏️ Editar
                    </button>
                    <button
                    :class="['btn', produto.active ? 'btn-inativar' : 'btn-ativar']"
                    @click="alternarStatusProduto(produto)">
                    {{ produto.active ? '🚫 Desativar' : '✅ Ativar' }}
                  </button>
                  </td>
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
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Head, router } from '@inertiajs/vue3'

const produtos = ref([])

const getImagens = (imagem) => {
  if (Array.isArray(imagem)) {
    return imagem
  }

  try {
    const parsed = JSON.parse(imagem)
    if (Array.isArray(parsed)) return parsed
    return [parsed]
  } catch (e) {
    return [imagem]
  }
}

const fetchProdutos = async () => {
  try {
    const response = await axios.get('/api/products')
    produtos.value = response.data
  } catch (error) {
    console.error('Erro ao buscar produtos:', error)
  }
}

const editarProduto = (id) => {
  if (id) {
    router.get(`/produtos/${id}/editar`)
  }else {
    console.error('ID do produto não encontrado.')
  }
}

const alternarStatusProduto = async (produto) => {
  const acao = produto.active ? 'inativar' : 'ativar'
  if (!confirm(`Deseja realmente ${acao} "${produto.title}"?`)) return

  try {
    await axios.patch(`/api/products/${produto.id}/toggle`, { active: !produto.active })
    fetchProdutos()
  } catch (error) {
    console.error(`Erro ao ${acao} produto:`, error)
  }
}

onMounted(fetchProdutos)
</script>


<style scoped>
.table-container {
  max-width: 900px;
  margin: 40px auto;
  padding: 20px;
}

h1 {
  text-align: center;
  font-size: 24px;
  margin-bottom: 30px;
  color: #333;
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

.acoes {
  display: flex;
  gap: 10px;
}

.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
  color: #fff;
}

.btn-editar {
  background-color: #3b82f6; /* Azul */
}

.btn-editar:hover {
  background-color: #2563eb;
}

.btn-inativar {
  background-color: #ef4444; /* Vermelho */
}

.btn-inativar:hover {
  background-color: #dc2626;
}

.btn-ativar {
  background-color: #10b981; /* Verde */
}

.btn-ativar:hover {
  background-color: #059669;
}

.miniatura {
  width: 50px;
  height: auto;
  margin-right: 5px;
  border-radius: 4px;
}
</style>
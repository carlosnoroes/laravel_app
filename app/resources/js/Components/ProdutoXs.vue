<template>
  <div class="container">
    <h1>📦 Lista de Produtos</h1>

    <table>
      <thead>
        <tr>
          <th>Título</th>
          <th>Preço de Venda</th>
          <th>Preço de Custo</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="produto in produtos" :key="produto.id">
          <td>{{ produto.title }}</td>
          <td>R$ {{ produto.price_sale }}</td>
          <td>R$ {{ produto.price_cost }}</td>
          <td>{{ produto.active ? 'Ativo' : 'Inativo' }}</td>
          <td>
            <button @click="editarProduto(produto)">✏️ Editar</button>
            <button @click="inativarProduto(produto)">🚫 Inativar</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Produtos',
  data() {
    return {
      produtos: []
    }
  },
  methods: {
    async fetchProdutos() {
      try {
        const response = await axios.get('/api/products')
        this.produtos = response.data
      } catch (error) {
        console.error('Erro ao buscar produtos:', error)
      }
    },
    editarProduto(produto) {
      alert(`Editar produto: ${produto.title}`)
      // Aqui você pode redirecionar para uma tela de edição
    },
    async inativarProduto(produto) {
      if (!confirm(`Deseja realmente inativar "${produto.title}"?`)) return

      try {
        await axios.put(`/api/products/${produto.id}`, { active: false })
        this.fetchProdutos()
      } catch (error) {
        console.error('Erro ao inativar produto:', error)
      }
    }
  },
  mounted() {
    this.fetchProdutos()
  }
}
</script>

<style scoped>
.container {
  max-width: 900px;
  margin: 0 auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  font-family: Arial, sans-serif;
}

th, td {
  padding: 10px;
  border: 1px solid #ddd;
  text-align: left;
}

th {
  background-color: #f5f5f5;
}

button {
  margin-right: 5px;
  padding: 5px 10px;
  font-size: 14px;
  cursor: pointer;
}
</style>
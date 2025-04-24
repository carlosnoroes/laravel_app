<template>
  <Head title="Gerenciar Produtos" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">✏️ Editar Produto</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submit" enctype="multipart/form-data">
              <div class="form-group">
                <label>Título:</label>
                <input v-model="form.title" type="text" required placeholder="Digite o título do produto" />
              </div>

              <div class="form-group">
                <label>Preço de Venda:</label>
                <input v-model="form.price_sale" type="number" step="0.01" required placeholder="Digite o preço de venda" />
              </div>

              <div class="form-group">
                <label>Preço de Custo:</label>
                <input v-model="form.price_cost" type="number" step="0.01" required placeholder="Digite o preço de custo" />
              </div>

              <div class="form-group">
                <label>Descrição:</label>
                <textarea v-model="form.description" placeholder="Digite a descrição do produto"></textarea>
              </div>

              <div v-if="produto.images && produto.images.length" class="imagem-preview">
                <label>Imagens atuais:</label>
                <div class="preview-multiplas">
                  <img
                    v-for="(img, index) in produto.images"
                    :key="index"
                    :src="`/storage/${img}`"
                    alt="Imagem do Produto"
                    class="preview-img"
                  />
                </div>
              </div>

              <div class="form-group">
                <label>Imagem do Produto:</label>
                <input type="file" multiple @change="handleImageUpload" accept="image/png, image/jpeg" />
                <p v-if="form.image">Imagem selecionada: {{ form.image.name }}</p>
              </div>

              <div class="form-group">
                <label for="active">Status</label>
                <select id="active" v-model="form.active">
                  <option :value="true">Ativo</option>
                  <option :value="false">Inativo</option>
                </select>
              </div>

              <div class="form-actions">
                <button type="submit">💾 Salvar</button>
                <button type="button" @click="cancelEdit">Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'

const props = defineProps({
  produto: {
    type: Object,
    default: () => ({})
  },
  user_id: Number,
  id: {
    type: Number,
    default: null
  }
})

// Form
const form = useForm({
  title: props.produto?.title ?? '',
  price_sale: props.produto?.price_sale ?? '',
  price_cost: props.produto?.price_cost ?? '',
  description: props.produto?.description ?? '',
  active: props.produto?.active == true || props.produto?.active == 1 || props.produto?.active === '1',
  images: [],
  acao: props.id ? 'Edição' : 'Criação',
  user_id: props.user_id
})

// Função de upload de imagem
const handleImageUpload = (event) => {
  form.images = Array.from(event.target.files)
}

// Função de envio de formulário
const submit = async () => {
  const precoMinimo =(form.price_cost * 1.1).toFixed(2)
  if (form.price_sale < precoMinimo) {
    alert(`O preço de venda não deve ser inferior a R$ ${precoMinimo}`)
    return
  }

  const formData = new FormData()
  formData.append('title', form.title)
  formData.append('price_sale', form.price_sale)
  formData.append('price_cost', form.price_cost)
  formData.append('description', form.description)
  formData.append('active', form.active ? 1 : 0)
  formData.append('acao', form.acao)
  formData.append('user_id', form.user_id)

  if (form.images && form.images.length > 0) {
    form.images.forEach((image) => {
      formData.append('images[]', image)
    })
  }

  try {
  if (props.id) {
    formData.append('_method', 'PUT')
    await axios.post(`/api/products/${props.id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    alert('Produto atualizado com sucesso!')
  } else {
    await axios.post('/api/products', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    alert('Produto criado com sucesso!')
  }
    router.get('/produtos')
  } catch (error) {
    alert('Erro ao salvar dados do produto.')
  }
}

// Função de cancelamento da edição
const cancelEdit = () => {
  window.history.back()  // Redireciona de volta à página anterior
}
</script>


<style scoped>
.container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9fafb;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 20px;
}

label {
  font-weight: 600;
  font-size: 16px;
  color: #444;
}

input, select, textarea {
  width: 100%;
  padding: 10px;
  margin-top: 8px;
  border-radius: 4px;
  border: 1px solid #ddd;
  font-size: 14px;
  color: #333;
}

input[type="file"] {
  padding: 5px;
}

textarea {
  resize: vertical;
  min-height: 100px;
}

button {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  margin-right: 10px;
}

button:hover {
  background-color: #45a049;
}

button[type="button"] {
  background-color: #f44336;
}

button[type="button"]:hover {
  background-color: #e53935;
}

.form-actions {
  display: flex;
  justify-content: flex-start;
  gap: 10px;
}

p {
  font-size: 14px;
  color: #555;
  margin-top: 5px;
}

.imagem-preview {
  margin-top: 15px;
}

.preview-img {
  max-width: 200px;
  height: auto;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>
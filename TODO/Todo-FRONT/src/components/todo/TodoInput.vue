<template>
    <div class="inputBox shadow">
        <input type="text" v-model="newTodoItem" @keyup.enter="addTodo" placeholder="Type what you have to do">
        <span class="addContainer" @click="addTodo">
            <i class="addBtn fas fa-plus"></i>
        </span>
    </div>
</template>

<script>
export default {
    data() {
        return {
            newTodoItem: ''
        }
    },
    methods: {
        addTodo() {
            if(this.newTodoItem.trim() !== '') { 
                const value = this.newTodoItem.trim();
                // localStorage.setItem(value, value);
                this.$emit('addTodo', value);
            } else { this.$emit('modalOpen'); }
            this.newTodoItem = '';
        }
    }
}
</script>

<style scoped>
    input:focus { outline: none; }
    .inputBox {
        max-width: 540px;
        display: flex;
        background-color: white;
        height: 50px;
        line-height: 50px;
        border-radius: 5px;
        padding-left: 5px;
        margin: 0 auto;
    }
    .inputBox input { 
        border-style: none; 
        font-size: 0.9rem; 
        flex-grow: 1;
        padding: 0 10px; 
    }
    .addContainer {
        cursor: pointer;
        background: linear-gradient(to right, #6478FB, #8763FB);
        width: 3rem;
        border-radius: 0 5px 5px 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .addContainer > .addBtn {
        color: white;

    }
</style>
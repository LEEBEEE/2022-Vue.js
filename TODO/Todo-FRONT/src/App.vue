<template>
  <TodoHeader></TodoHeader>
  <TodoInput @addTodo="addTodo" @modalOpen="modalOpen"></TodoInput>
  <TodoList :propsItems="todoItems" @removeTodo="removeTodo"></TodoList>
  <TodoFooter @clearTodo="clearTodo"></TodoFooter>
  <AlertModal :show="modalShow" @close="close" header="알림창" body="내용을 입력해주세요."></AlertModal>
</template>

<script>
import TodoHeader from './components/todo/TodoHeader.vue';
import TodoInput from './components/todo/TodoInput.vue';
import TodoList from './components/todo/TodoList.vue';
import TodoFooter from './components/todo/TodoFooter.vue';
import AlertModal from './components/common/AlertModal.vue';
import axios from 'axios';
import DateUtils from './utils/DateUtils';

export default {
  name: 'App',
  data() {
    return {
      todoItems: [],
      modalShow: false
    }
  },
  methods: {
    modalOpen(){
      this.modalShow = true;
    },
    close() {
      this.modalShow = false;
    },
    addTodo(todoItem) {
      const param = {
        'todo': todoItem
      }
      axios.post('/todo/index', param)
      .then(res =>{
        if(res.status === 200 && res.data) {
          const item = {
            'itodo': res.data.result,
            'todo': todoItem,
            'create_at': DateUtils.getTimestamp(new Date())
          }
          this.todoItems.push(item);
        }
      });
      
    },
    removeTodo(itodo) {
      // this.todoItems.splice(idx, 1);
      this.todoItems.forEach((item, idx) => {
        if(item.itodo === itodo) {
          this.todoItems.splice(idx, 1);
          axios.delete(`/todo/index/${item.itodo}`)
          .then(res => {
            console.log(res);
          })
        }
      })
    },
    clearTodo() {
      axios.delete('/todo/index')
      .then(res => {
        if(res.status === 200 && res.data) {
          this.todoItems.splice(0);
        }
      })
    },
    changeValue() {
      const json = JSON.stringify(this.todoItems);
      localStorage.setItem('todoItems', json);
      // localStorage.setItem('cnt', this.cnt);
    }
  },
  created() {
    // DB와 통신
    axios.get('/todo/index')
    .then(res => {
      // console.log(res);
      if(res.status === 200 && res.data.length > 0) {
        res.data.forEach(item => {
          this.todoItems.push(item);
        })
      }
    });

    // localStorage를 이용했을 때
    // const json = localStorage.getItem("todoItems");
    // if(json){
    //   const todoItems = JSON.parse(json);
    //   todoItems.forEach(item => {
    //     this.todoItems.push(item);
    //   });
    //   const cnt = localStorage.getItem("cnt");
    //   this.cnt = cnt;
    // }
  },
  watch: {
    todoItems: {
      deep: true,
      handler() {
        this.changeValue();
      }
    }
  },
  components: {
    TodoHeader,
    TodoInput,
    TodoList,
    TodoFooter,
    AlertModal
  }
}
</script>

<style>
  body { text-align: center; background-color: #F6F6F8; }
  input { border-style: groove; width: 200px; }
  button { border-style: groove; }
  .shadow { box-shadow: 5px 10px 10px rgba(0, 0, 0, 0.03); }
  .d-flex { display: flex; }
  .flex-row { flex-direction: row; }
  .flex-col { flex-direction: column; }
  .grow_1 { flex-grow: 1; }
  .ctnt { font-size: 1rem; }
  .justify_content_evenly { justify-content: space-evenly;}
</style>

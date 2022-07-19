<template>
  <section>
    <transition-group name="list" tag="ul">
      <li :key="todoItem.itodo" v-for="todoItem in propsItems" class="shadow">
        <i class="checkBtn fas fa-check" aria-hidden="true"></i>
        <div class="grow_1 d-flex flex-col justify_content_evenly">
          <div class="ctnt">{{ todoItem.todo }}</div>
          <div class="small_text">{{ todoItem.create_at }}</div>
        </div>
        <span class="removeBtn" type="button" @click="removeTodo(todoItem.itodo)">
          <i class="far fa-trash-alt" aria-hidden="truer"></i>
        </span>
      </li>
    </transition-group>
  </section>
</template>

<script>
export default {
  props: {
    propsItems: Array
  },
  methods: {
    removeTodo(itodo) {
      this.$emit('removeTodo', itodo);

    }
  }
}
</script>

<style scoped>
  .list-enter-active, .list-leave-active { transition: all 0.7s; }
  .list-enter-from { opacity: 0; transform: translate(-30px);}
  .list-leave-to { opacity: 0; transform: translate(30px);}
  section {
        max-width: 760px;
        margin: 2rem auto;
  }
  ul {
    list-style: none;
    padding-left: 0;
    margin-top: 0;
    text-align: left;
  }
  li {
    display: flex;
    margin: 0.5rem 0;
    padding: 0.5rem 0.9rem;
    background-color: white;
    border-radius: 5px;
  }
  .checkBtn {
    line-height: 50px;
    color: #62acde;
    margin-right: 20px;
  }
  .removeBtn { line-height: 50px; margin-left: auto; color: #de4343; }
  .small_text { font-size: .8rem; color: #828181;}
</style>
<template>
  <main class="mt-3">
    <div class="container">
      <div class="float-end mb-1">
        <router-link class="nav-link" to="/create">
          <button type="button" class="btn btn-dark">제품 등록</button>
        </router-link>
      </div>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th></th>
            <th>제품명</th>
            <th>제품가격</th>
            <th>배송비</th>
            <th>추가 배송비</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr :key="item.id" v-for="(item, idx) in product">
            <td>
              <img v-if="item.path !== null" 
              :src="`/static/img/${item.id}/1/${item.path}`" 
              style="height:50px; width:auto;">
            </td>
            <td>{{ item.product_name }}</td>
            <td>{{ item.product_price }}</td>
            <td>{{ item.delivery_price }}</td>
            <td>{{ item.add_delivery_price }}</td>
            <td class="d-flex flex-wrap">
              <!-- <router-link class="nav-link" :to="{path: '/imageInsert', query: {product_id: item.id}}">
                <button type="button" class="btn btn-info me-1">사진등록</button>
              </router-link> -->
              <button type="button" class="btn btn-info me-1" @click="goToImageInsert(idx)">사진등록</button>
              <router-link class="nav-link" :to="{path: '/update', query: {product_id: item.id}}">
                <button type="button" class="btn btn-warning me-1">수정</button>
              </router-link>
                <button type="button" class="btn btn-danger me-1" @click="delProduct(item.id, idx)">삭제</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      product: [],
      cate1List: [],
      cate2List: [],
      cate3List: []
    };
  },
  created() {
    this.getProductList();
  },
  methods: {
    async getProductList() {
      this.product = await this.$get('/api/productList2', {});
    },
    goToImageInsert(idx) {
      this.$store.commit('sallerSelectedProduct', this.product[idx]);
      this.$router.push( {path: '/imageInsert'} );
    },
    async delProduct(id, idx) {
      console.log(id);
      // const rs = await this.$delete(`/api/deleteProduct/${id}`); // 강사님 풀이

      this.$swal.fire({
        title: '정말 삭제 하시겠습니까?',
        showCancelButton: true, 
        confirmButtonText: '삭제',
        cancelButtonText: '취소'
      }).then(async result => {
        if(result.isConfirmed) {
          const rs = await this.$delete(`/api/delProduct/${id}`);
          if(rs.result) {
            this.product.splice(idx, 1);
            this.$swal.fire('삭제되었습니다.', '', 'success');
          }
        }
      });
    }
  }
}
</script>

<style>

</style>
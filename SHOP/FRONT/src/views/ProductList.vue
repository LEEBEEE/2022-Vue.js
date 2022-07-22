<template>
  <main class="mt-3">
    <div class="container">
      <div class="row mb-2">
        <div class="col-12">
          <!-- <select class="form-select mw-18rem">
            <option selected>---</option>
            <option value="1">노트북</option>
            <option value="2">모니터</option>
            <option value="3">마우스 / 키보드</option>
          </select> -->

          <select  @change="changeCate1" v-model="selectedCate1">
            <option value="" selected>전체</option>
            <option v-for="item in cate1List" :key="item.cate_nm">
              {{ item.cate_nm }}
            </option>
          </select>

          <select  @change="changeCate2" v-model="selectedCate2" v-if="selectedCate1 !== ''">
            <option value="" selected>전체</option>
            <option v-for="item in cate2List" :key="item.cate_nm">
              {{ item.cate_nm }}
            </option>
          </select>

          <select  @change="getProductList" v-model="selectedCate3" v-if="selectedCate2 !== ''">
            <option value="0" selected>전체</option>
            <option v-for="item in cate3List" :key="item.id" :value="item.id">
              {{ item.cate_nm }}
            </option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6" :key="item.id" v-for="item in product">
          <div class="card" style="width: 18rem;">
            <a @click="goToDetail(item.id)" style="cursor:pointer;">
              <img :src="`/static/img/${item.id}/${item.type}/${item.path}`" class="card-img-top" alt="이미지">
            </a>
            <div class="card-body">
              <h5 class="card-title">{{ item.product_name }}</h5>
              <p class="card-text">
                <span class="badge bg-dark text-white me-1">{{ item.cate1 }}</span>
                <span class="badge bg-dark text-white me-1">{{ item.cate2 }}</span>
                <span class="badge bg-dark text-white me-1">{{ item.cate3 }}</span>
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group" role="group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">🛒</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">💸</button>
                </div>
                  <small class="text-dark">{{ item.product_price }}원</small>
              </div>
            </div>
          </div>
        </div>
      </div>
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
    cate3List: [],
    selectedCate1: '',
    selectedCate2: '',
    selectedCate3: 0,
  }
 },
  created() {
    this.getProductList();
    this.getCate1List();
  },
  // updated() {
  //   this.getProductList();
  // },
  methods: {
    changeCate1() {
      this.selectedCate2 = '';
      this.selectedCate3 = 0;
      this.cate2List = [];
      this.cate3List = [];
      this.getCate2List(this.selectedCate1);
      this.getProductList();
    },
    changeCate2() {
      this.selectedCate3 = 0;
      this.cate3List = [];
      this.getCate3List(this.selectedCate1, this.selectedCate2);
      this.getProductList();
    },
    
    async getProductList() {      
      const param = {};
      if(this.selectedCate3 > 0) {
        param['cate3'] = this.selectedCate3;
      } else {
        if(this.selectedCate1 !== '') {
          param['cate1'] = this.selectedCate1;
        }
        if(this.selectedCate2 !== '') {
          param['cate2'] = this.selectedCate2;
        }
      }      
      this.product = await this.$get('/api/productList', param);
    },
    async getCate1List() {
      this.cate1List = await this.$get('/api/cate1List', {});
    },
    async getCate2List(cate1) {
      this.cate2List = await this.$get(`/api/cate2List/${cate1}`, {});
    },
    async getCate3List(cate1, cate2) {
      this.cate3List = await this.$get(`/api/cate3List/${cate1}/${cate2}`, {});
    }
  }
}
</script>

<style scoped>
  .mw-18rem { max-width: 18rem; }
</style>
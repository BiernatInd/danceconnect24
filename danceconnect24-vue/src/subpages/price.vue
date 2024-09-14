<template>
  <MainHeader />

  <div class="price">
    <div class="price-content">
      <div class="price-top">
        <h2>Price list</h2>
      </div>
      <div class="price-bottom">
        <div class="price-bottom-item-box">
          <h2>Dance</h2>
          <div class="price-bottom-item">
            <p>Price per hour approximately</p>
            <p>80 AED</p>
          </div>
          <div class="price-bottom-item">
            <p>In the package</p>
            <p>70 AED</p>
          </div>
        </div>
        <div class="price-bottom-item-box">
          <h2>Private dance</h2>
          <div class="price-bottom-item">
            <p>Rates are AED 300 for 1 hour class</p>
          </div>
          <div class="price-bottom-item">
            <p>AED 2,700 for 10 hours classe</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <MainFooter />
</template>

<script>
import MainHeader from "@main-components/main-header.vue";
import MainFooter from "@main-components/main-footer.vue";

export default {
  components: {
    MainHeader,
    MainFooter,
  },
};
</script>

<style lang="scss" scoped>
.price {
  width: 100%;
  padding-top: 100px;

  background: url("@bg/bg-1.png");
  background-repeat: no-repeat;
  background-position-x: 100%;
  .price-content {
    width: 95%;
    margin-left: auto;
    margin-right: auto;
    .price-top {
      width: 100%;
      border-radius: 15px;
      padding: 1rem;
      box-shadow: var(--box-shadow);
      margin-bottom: 2rem;
      background-color: var(--white);
      h2 {
        font-size: 24px;
        font-weight: 400;
        text-align: center;
      }
    }
    .price-bottom {
      display: flex;
      justify-content: space-between;
      .price-bottom-item-box {
        width: calc(50% - 1rem);
        padding: 1rem;
        box-shadow: var(--box-shadow);
        border-radius: 15px;
        background-color: var(--white);

        h2 {
          font-size: 24px;
          color: var(--black);
          font-weight: 500;
          margin-bottom: 1rem;
        }
        .price-bottom-item:not(:last-child) {
          margin-bottom: 1rem;
        }
        .price-bottom-item {
          display: flex;
          justify-content: space-between;
          padding-bottom: 1rem;
          border-bottom: 1px solid var(--pink);
        }
      }
    }
  }
}

@media screen and (max-width: 1200px) {
  .price {
    background: none;
    .price-content {
      .price-top {
        h2 {
          font-size: 24px;
        }
      }
      .price-bottom {
        flex-direction: column;
        .price-bottom-item-box:not(:last-child) {
          margin-bottom: 2rem;
        }
        .price-bottom-item-box {
          width: 100%;
          h2 {
            font-size: 24px;
          }
          .price-bottom-item {
            width: 100%;
            p {
              font-size: 16px;
            }
          }
        }
      }
    }
  }
}
</style>

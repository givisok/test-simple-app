<template>
    <div v-if="!products || products.length == 0">Empty</div>
    <div v-else class="col-md-12">
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th width="*">Product</th>
                    <th width="10%">Price</th>
                    <th width="10%">Qty</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, index) in products">
                    <td>{{product.name}}</td>
                    <td>{{product.real_price}}</td>
                    <td>{{product.quantity}}</td>
                </tr>
                </tbody>
            </table>
            <h4>Total price: ${{totalPrice}}</h4>
            <button class="btn btn-default" @click="clearCart()">Clear Cart</button>
            <button class="btn btn-success" @click="checkout()">Checkout</button>
        </div>
    </div>
</template>
<script>
    import {mapActions} from 'vuex';

    export default {
        computed: {
            products() {
                return this.$store.getters.basket;
            },
            totalPrice() {
                return this.$store.getters.basket.reduce((previousValue, currentValue) => {
                    return Number(previousValue) + Number(currentValue.real_price) * Number(currentValue.quantity);
                }, 0);
            }
        },
        methods: {
            checkout() {
                if (!this.$store.getters.count) {
                    return;
                }
                document.location.href = "/checkout";
            },
            ...mapActions(['clearCart'])
        }
    }
</script>

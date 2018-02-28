<template>
    <tr>
        <td>{{product.name}}</td>
        <td>${{product.real_price}}</td>
        <td>
            <input name="qty" v-model="qty" class="form-control" type="number" step="1" min="1"/>
        </td>
        <td class="text-right">
            <button class="btn btn-success" @click="order()">Order</button>
        </td>
    </tr>
</template>
<script>
    export default {
        data: () => {
            return {
                qty: 1
            }
        },
        props: {
            product: {
                type: Object
            }
        },
        methods: {
            validateInput() {
                if (this.qty < 0 || this.qty > 100) {
                    alert('Bad quantity.');
                    this.qty = 1;

                    return false;
                }
                if (this.$store.getters.count + Number(this.qty) > 1000) {
                    alert('You cannot pay for that :)');
                    return false;
                }

                return true;
            },
            order() {
                if (this.validateInput()) {
                    this.$store.dispatch('addToCart', {product: this.product, quantity: this.qty});
                }
            },
        },
    }
</script>

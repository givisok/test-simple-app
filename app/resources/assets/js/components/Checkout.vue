<template>
    <div>
        <div>
            <div v-if="paid == true"><h2>Success pay!</h2>
                <p>We sent email with order details to you.</p>
                <p>If you don't get it please contact with us by phone 555-555-555</p>
                <a href="/">Go to store...</a>
            </div>
            <div v-if="errorPay == true"><h2>Payment failed!</h2>
                <p>Error: {{this.errorMessage}}</p>
                <p>
                    <button v-if="$parent.cartCount != 0" class="btn btn-default" @click="returnToForm()">
                        Return to form and try again...
                    </button>
                    <a v-else href="/">Go to store...</a>
                </p>
            </div>

            <div v-if="$parent.cartCount == 0 && paid == false">You need to order something.
                <a href="/">Go to store...</a>
            </div>
            <form v-else-if="errorPay == false && paid == false" v-on:submit.prevent="checkout">
                <div :class="{'form-group': true, 'has-error': errors.has('name') }">
                    <input class="form-control" name="name" placeholder="Name" v-validate="'required|min:2|max:255'"
                           v-model="form.user_name"/>
                </div>

                <div :class="{'form-group': true, 'has-error': errors.has('email') }">
                    <input class="form-control" name="email" placeholder="Email" v-model="form.user_email"
                           v-validate="'required|email'" type="text"/>
                </div>

                <div :class="{'form-group': true, 'has-error': errors.has('address') }">
                    <input class="form-control" name="address" placeholder="Address"
                           v-validate="'required|min:10|max:255'"
                           v-model="form.address"/>
                </div>
                <card class='stripe-card' v-bind:stripe="pbtoken"/>
                <div v-if="loading" class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
                <div v-else class="panel panel-default">
                    <div class="panel-body">
                        <button class="btn btn-success pull-right">Checkout</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    // If it was a real app I will prefer to use sessions.
    // In this case I would use session after create order.
    // I would store order id in session and then checkout by order id.
    // Or we can use more complex logic.
    // Anyway business logic can be different...
    import {mapActions} from 'vuex';

    import {Card, createToken} from 'vue-stripe-elements';

    export default {
        components: {
            Card,
            createToken
        },
        props: {
            pbtoken: ''
        },
        data: () => {
            return {
                stripeOptions: {
                    // see https://stripe.com/docs/stripe.js#element-options for details
                },
                errorPay: false,
                errorMessage: '',
                paid: false,
                loading: false,
                form: {
                    user_name: null,
                    user_email: null,
                    address: null,
                }
            };
        },

        methods: {
            ...mapActions(['clearCart']),
            returnToForm() {
                this.errorMessage = '';
                this.errorPay = false;
            },
            checkout() {
                if (this.loading) {
                    return;
                }
                this.$validator.validateAll().then((result) => {
                    if (!result) {
                        return;
                    }
                    this.loading = true;

                    createToken().then(data => {
                        if (!data || !data.token || !data.token.id) {
                            this.errorPay = true;
                            this.errorMessage = 'Card decline! Bad token.';
                            this.loading = false;

                            return;
                        }

                        this.form['token'] = data.token.id;

                        axios.post('/api/checkout-process', {
                            order: this.form,
                            products: this.$store.getters.basket
                        }).then((response) => {
                            if (response.data['success']) {
                                this.paid = true;
                                this.clearCart();
                            } else if (response.data['error']) {
                                this.errorPay = true;
                                // we can clear cart on some errors. We can use switch :)
                                if (response.data.error === 'order_status') {
                                    this.clearCart();
                                } else {
                                    this.errorMessage = response.data['error_description'] || '';
                                }
                            }
                        }).catch((e) => {
                            this.errorPay = true;
                            this.errorMessage = 'Some magic is happening!'
                        }).then(() => {
                            this.loading = false;
                        });
                    });
                });
            }
        }
    }
</script>

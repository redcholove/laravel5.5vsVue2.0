<template>
    <div class="buying-page">
        <div class="header">
            <input type="text" class="search" placeholder="yo...">
        </div>
        <div class="content">
            <div class="img" v-bind:style="{ 'background-image': 'url(' + vImage + ')' }"></div>
            <div class="detail">
                <p class="Name">{{vName}}</p>
                <p class="Des">{{vDes}}</p>
		<p class="MaxCount">商品庫存:{{maxcount}}</p>
                <input type="number" class="Count" v-model="count" v-on:keyup="keyup">
                <button class="add" v-on:click="add">+</button>
                <button class="addreverse" v-on:click="addreverse">-</button>
                <br>
                <button class="confirmbuy" v-on:click="buy">buy</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'chatroom',
        data: function() {
            return {
                maxcount: this.$route.params.iCount,
                iId: this.$route.params.iId,
                vName: this.$route.params.vName,
                vDes: this.$route.params.vDes,
                count: 1,
                vImage: this.$route.params.vImage,
                apiUrl: 'http://localhost/saturday/public/buy'
            }
        },
        mounted: function() {
        },
        methods: {
            keyup: function() {
                if (this.count > this.maxcount) {
                    alert('無法購買此數量商品');
                    this.count = 1;
                }
            },
            add: function() {
                if (this.count === this.maxcount) {
                    alert('超出庫存數量');
                } else {
                    this.count = parseInt(this.count) + 1;
                }

            },
            addreverse: function() {
                if (this.count === 1) {
                    alert('至少購買一項以上的商品');
                } else {
                    this.count = parseInt(this.count) - 1;
                }
            },
            buy: function() {
		if ( this.count < 1 ) {
		    alert('請至少購買一項商品');
		    return 0;
		}
		if ( this.count > this.maxcount ) {
	            alert('購買數量超過庫存數量');
		    this.count = 1;
		    return 0;
		}
                var toServer = {
                    id: this.iId,
                    count: this.count
                }
                this.$http.post(this.apiUrl, toServer)
                    .then((r) => {
                        this.$router.push('/');
                    })
                    .catch((r) => {
                        alert(r.body.message);
                    });
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>

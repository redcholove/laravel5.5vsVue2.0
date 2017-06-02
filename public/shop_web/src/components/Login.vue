<template>
   <div class="all-sale">
        <div class="header">
            <input type="text" class="search" placeholder="Search...">
            <button class="login" v-on:click="login">Login</button>
        </div>
        <div class="add">
            <button class="add-button" v-on:click="addnew">add</button>
        </div>
        
        
        <div class="shoplist">
            <div class="single-sale" v-for="item in saleArry">
                <div class="img" v-bind:style="{ 'background-image': 'url(' + item.vImage + ')' }"></div>
                <div class="content">
                    <font class="name">{{item.vName}}</font>
                    <font class="des">{{item.vDes}}</font>
                    <font class="count">商品庫存:{{item.iCount}}</font>
                    <button class="buy" v-on:click="buysale(item.iId, item.vImage, item.vName, item.vDes, item.iCount)" v-if="item.iCount != 0">購買</button>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        name: 'home',
        data() {
            return {
                apiUrl: 'http://localhost/saturday/public/getall',
                saleArry: []
            }
        },
        mounted: function() {
            this.$http.post(this.apiUrl)
                    .then((r) => {
                        for ( var i = 0; i<= r.body.info.length; i++ ){
                           
			   if ( r.body.info[i].iCount == 0 ) {
			   	r.body.info[i].iCount == '已售完';
			   } 
		           var param = {
                                iId: r.body.info[i].iId,
                                vName: r.body.info[i].vName,
                                vDes: r.body.info[i].vDes,
                                vImage: r.body.info[i].vImage,
                                iCount: r.body.info[i].iCount
                            }
                            
                            this.saleArry.push( param );
                        }
                    })
                    .catch((r) => {
//                        alert(r.body.message);
                    });
        },
        methods: {
            login: function () {
//                this.$router.push('/login');
                console.log('login');
                //                this.$http.post(this.apiUrl, toServer)
                //                    .then((r) => {
                //                        this.$router.push('/chatroom');
                //                    })
                //                    .catch((r) => {
                //                        console.log(r.body);
                //                    });
            },
            addnew: function () {
                this.$router.push('/addnew');
            },
            buysale: function (id, image, name , des, count) {
                this.$router.push({
                    name: 'ChatRoom',
                    params: {
                        iId: id,
                        vImage: image,
                        vName: name,
                        vDes: des,
                        iCount: count
                    }
                });
//                this.$router.push('/buysale');
            }
        }
    }
</script>

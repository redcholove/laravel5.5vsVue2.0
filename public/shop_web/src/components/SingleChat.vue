<template>
    <div class="add-content">
        <div class="header">
            <input type="text" class="search" placeholder="search...">
            <button class="login">Login</button>
        </div>
        <div class="content">
            <div class="img" v-bind:style="{ 'background-image': 'url(' + addSalesImg + ')' }">
                <input type="file" v-on:change="sales_img_upload" accept="image/gif, image/jpeg, image/png">
            </div>
            <div class="input">
                <br>
                <label>名稱</label>
                <br>
                <input type="text" placeholder="input Name..." v-model="Name">
                <br>
                <label>敘述</label>
                <br>
                <input type="text" placeholder="input Des..." v-model="Des">
                <br>
                <label>商品數量</label>
                <br>
                <input type="number" placeholder="input Count..." v-model="Num">
            </div>
            <button class="confirm" v-on:click="confirm()">confirm add</button>
            
        </div>
    </div>
</template>

<script>
    export default {
        name: 'room',
        data() {
            return {
                title: '與Red的對話',
                addSalesImg: './dist/img/_upload_image-512.png',
                Name: '',
                Des: '',
                Num: null,
                apiUrl: 'http://localhost/saturday/public/test'
//                                    roomId: this.$route.params.roomId,
//                                    roomName: this.$route.params.name
            }
        },
        mounted: function() {

            //            function logArrayElements(element, index, array) {
            //                if (element.roomId == roomId) {
            //                    element.badge = 0;
            //                }
            //            };
            //            this.roomList.forEach(logArrayElements);
            //            for (var i = 0; i < data.length; i++) {
            //                        var temp = self.messageListItem(data[i]);
            //                        if (temp.left === true) {
            //                            temp.left = 'msg left';
            //                            temp.lb = true;
            //                        } else {
            //                            temp.left = 'msg right';
            //                            temp.lb = false;
            //                        }
            //                        self.history_msg.push(temp);
            //                    };
        },
        methods: {
            confirm: function() {
                var toServer = {
                    name: this.Name,
                    des: this.Des,
                    number: this.Num,
                    img: this.addSalesImg
                }

                console.log(toServer);
                this.$http.post(this.apiUrl, toServer)
                    .then((r) => {
                        this.$router.push('/');
                    })
                    .catch((r) => {
                        this.$router.push('/');
                    });
            },
            sales_img_upload: function(e) {

                var reader = new FileReader(),
                    self = this;
                reader.onload = function(e) {
                    self.addSalesImg = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        }
    }
</script>
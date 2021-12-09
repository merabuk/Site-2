<template>
<div class="d-inline">
    <button type="button" :class="btnClass" v-html="btnHtml" v-on:click="doAction"></button>
</div>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                required: false,
                default: 'default',
            },
            btnIcon: {
                type: String,
                required: false,
                default: '',
            },
            btnText: {
                type: String,
                required: false,
                default: '',
            },
            title: {
                type: String,
                required: true,
            },
            text: {
                type: String,
                required: true,
            },
            actionText: {
                type: String,
                required: false,
                default: 'Удалить'
            },
            actionUrl: {
                type: String,
                required: false,
            },
            actionMethod: {
                type: String,
                required: true,
            },
            actionData: {
                type: String,
                required: false,
            },
        },
        data() {
            return {

            }
        },
        computed: {
            //Определение параметров по типу
            btnClass() {
                return 'btn btn-sm btn-'+this.type;
            },
            btnHtml() {
                if(this.btnIcon) {
                    return '<i class="'+this.btnIcon+'"></i> '+this.btnText;
                } else {
                    return '';
                }
            }
        },
        methods: {
            doAction() {
                switch (this.actionMethod) {
                    case 'get':

                        break;
                    case 'post':

                        break;
                    case 'put':

                        break;
                    case 'delete':
                        Swal.fire({
                            titleText: this.title,
                            text: this.text,
                            icon: 'error',
                            showConfirmButton: true,
                            confirmButtonText: this.actionText,
                            focusConfirm: false,
                            showCancelButton: true,
                            cancelButtonText: 'Отмена',
                            focusCancel: true,
                            reverseButtons: true,
                        }).then((result) => {
                                if (result.value) {
                                    //OK
                                    axios.delete(this.actionUrl)
                                         .then(res => {
                                            if (res.data == 'deleted') {
                                                document.location.reload();
                                            };
                                         });
                                };
                                if (result.dismiss) {
                                    //Cancel

                                };
                        });
                        break;

                    default:

                        break;
                }
            }
        }
    }
</script>

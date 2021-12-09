<template>
    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
        <input class="custom-control-input" type="checkbox" :id="'customSwitches' + leadGroup.id" :checked="curentEnabled" @click="getData()"/>
        <label class="custom-control-label" :for="'customSwitches' + leadGroup.id"></label>
    </div>
  <!-- <input
    type="text"
    v-model="curentEnabled"
    @change="getData()"
  /> -->
</template>

<script>
export default {
  name: "LeadGroupEnabled",
  props: {
    token: Object,
    leadGroup: Object,
  },
  data() {
    return {
      config: {},
      curentEnabled: "",
    };
  },
  created() {
    this.curentEnabled = this.leadGroup.enabled;
    // прописываем токен авторизации в заголовок запроса
    this.config = {
      headers: {
        Authorization: "Bearer " + this.token.uuid,
      },
    };
  },
  methods: {
    getData() {
      this.curentEnabled = ! (!!this.curentEnabled);
      // для прохождения правил валидации сервереа заполняем необходимые поля существующими значениями
      let form = new FormData();
      // определяем метод PUT
      form.append("_method", "PUT");
      form.append("enabled", +(this.curentEnabled));

      this.updateLeadGroup(form);
    },
    updateLeadGroup(form) {
      return new Promise((resolve, reject) => {
        axios
          .post("api/lead-groups/" + this.leadGroup.id, form, this.config)
          .then((res) => {
            resolve(res.data);
          })
          .catch((err) => {
            console.log("getAll Error =", err);
          });
      });
    },
  },
  computed: {},
};
</script>

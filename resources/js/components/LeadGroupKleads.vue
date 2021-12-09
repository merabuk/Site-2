<template>
  <input
    type="text"
    v-model="curentK_leads"
    @change="getData()"
    size="5"
    
  />
</template>

<script>
export default {
  name: "LeadGroupKleads",
  props: {
    token: Object,
    leadGroup: Object,
  },
  data() {
    return {
      config: {},
      curentK_leads: "",
    };
  },
  created() {
    this.curentK_leads = this.leadGroup.k_leads;
    // прописываем токен авторизации в заголовок запроса
    this.config = {
      headers: {
        Authorization: "Bearer " + this.token.uuid,
      },
    };
  },
  methods: {
    getData() {
      // для прохождения правил валидации сервереа заполняем необходимые поля существующими значениями
      let form = new FormData();
      // определяем метод PUT
      form.append("_method", "PUT");
      form.append("k_leads", this.curentK_leads);

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

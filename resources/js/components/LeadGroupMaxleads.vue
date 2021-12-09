<template>
  <input
    type="text"
    v-model="curentMax_leads"
    @change="getData()"
    size="5"

  />
</template>

<script>
export default {
  name: "LeadGroupMaxleads",
  props: {
    token: Object,
    leadGroup: Object,
  },
  data() {
    return {
      config: {},
      curentMax_leads: "",
    };
  },
  created() {
    this.curentMax_leads = this.leadGroup.max_leads;
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
      form.append("max_leads", this.curentMax_leads);

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

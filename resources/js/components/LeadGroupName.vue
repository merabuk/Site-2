<template>
  <input
    type="text"
    v-model="curentName"
    @change="getData()"
    size="20"

  />
</template>

<script>
export default {
  name: "LeadGroupName",
  props: {
    token: Object,
    leadGroup: Object,
  },
  data() {
    return {
      config: {},
      curentName: "",
    };
  },
  created() {
    this.curentName = this.leadGroup.name;
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
      form.append("name", this.curentName);

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

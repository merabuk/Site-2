<template>
  <input
    :id="time"
    type="time"
    v-model="curentTime"
    @change="getData()"
    
  />
</template>

<script>
export default {
  name: "LeadGroupTime",
  props: {
    token: Object,
    leadGroup: Object,
    time: String,
  },
  data() {
    return {
      config: {},
      curentTime: "",
    };
  },
  created() {
    // проверяем какое значение редактируется в компоненте
    if (this.time == "open") {
      this.curentTime = this.leadGroup.open;
    } else {
      this.curentTime = this.leadGroup.close;
    }
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
      // в зависимости от того какое время редакируется заполняем поля open и close
      if (this.time == "open") {
        form.append("open", this.curentTime);
      } else {
        form.append("close", this.curentTime);
      }

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

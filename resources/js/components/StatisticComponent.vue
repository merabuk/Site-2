<template>
  <div class="table-responsive">
    <table
      id="leadStatuses"
      class="table table-sm table-striped table-bordered w-100"
    >
      <thead>
        <tr>
          <th @click="order('id')">#</th>
          <th @click="order('lead_group')">Офис</th>
          <th @click="order('lead_status')">Статус</th>
          <th @click="order(`'${index}'`)" v-for="(param, index) in params" :key="index">
            {{ param.name }}
          </th>
        </tr>
      </thead>
      <tbody>
        <template v-for="(lead, index) in allLeads">
          <tr :key="lead.id">
            <td>{{ index + 1 }}</td>
            <td>{{ lead.lead_group ? lead.lead_group.name : "" }}</td>
            <td>{{ lead.lead_status ? lead.lead_status.name : "" }}</td>
            <td v-for="(param, index) in params" :key="index">
              {{ lead.gets ? getValue(param.code, lead.gets, lead.utms) : "" }}
            </td>
          </tr>
        </template>
        <tr>
          <td>
            <select name="lead_group" v-model="checkedLeadGroup">
              <option v-for="lead in allLeads" :key="lead.id">
                {{ lead.lead_group ? lead.lead_group.name : "" }}
              </option>
            </select>
          </td>
          <td>
            <select name="lead_status" v-model="checkedLeadStatus">
              <option v-for="lead in allLeads" :key="lead.id">
                {{ lead.lead_status ? lead.lead_status.name : "" }}
              </option>
            </select>
          </td>
          <td>
            <select multiple name="params" v-model="checkedParams">
              <option
                v-for="(param, index) in params"
                :key="index"
                :value="param.name"
              >
                {{ param.name }}
              </option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "StatisticComponent",
  props: ["token", "params", "leads"],
  data() {
    return {
      config: {},
      checkedParams: [],
      checkedLeadGroup: 0,
      checkedLeadStatus: 0,
    };
  },
  created() {
    console.log("Component mounted.token = ", this.token.uuid);
    console.log("Component mounted.params = ", this.params);
    this.config = {
      headers: {
        Authorization: "Bearer " + this.token.uuid,
      },
    };
    // this.getAll().then((res) => {
    //   this.leads = res;
    //   console.log("res = ", res);
    // });
  },
  methods: {
    getAll() {
      return new Promise((resolve, reject) => {
        axios
          .get("api/getAll", this.config)
          .then((res) => {
            resolve(res.data);
          })
          .catch((err) => {
            console.log("getAll Error =", err);
          });
      });
    },
    getValue(columnName, gets, utms) {
      let value = _.filter(gets, function (item, index) {
        return index == columnName ? item : "";
      });

      if (!value.length) {
        value = _.filter(utms, function (item, index) {
          return index == columnName ? item : "";
        });
      }

      return value[0];
    },
  },
  computed: {
    allLeads() {
      return this.leads;
    },
  },
};
</script>

export const state = () => ({});

export const mutations = {};

export const getters = {};

export const actions = {

  index({ commit, dispatch, getters }, { params } = {}) {
    return this.$axios
      .$get("/type", { params: params })
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  getType({ commit, dispatch, getters }, { id } = {}) {
    return this.$axios
      .$get("/type/" + id)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  store({ commit, dispatch, getters }, { form } = {}) {
    return this.$axios
      .$post("/type", form)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  update({ commit, dispatch, getters }, { id, form } = {}) {
    return this.$axios
      .$post("/type/" + id, form)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  getListType({ commit, dispatch, getters }, { } = {}) {
    return this.$axios
      .$get("/type/list")
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  delete({ commit, dispatch, getters }, { id } = {}) {
    return this.$axios.$delete("/type/" + id).then((res) => {
      return Promise.resolve(res)
    }).catch(function (error) {
      return Promise.reject(error)
    });
  },
};

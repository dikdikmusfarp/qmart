export const state = () => ({});

export const mutations = {};

export const getters = {};

export const actions = {

  index({ commit, dispatch, getters }, { params } = {}) {
    return this.$axios
      .$get("/sale", { params: params })
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  getSale({ commit, dispatch, getters }, { id } = {}) {
    return this.$axios
      .$get("/sale/" + id)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  store({ commit, dispatch, getters }, { form } = {}) {
    return this.$axios
      .$post("/sale", form)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  update({ commit, dispatch, getters }, { id, form } = {}) {
    return this.$axios
      .$post("/sale/" + id, form)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

};

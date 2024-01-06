export const state = () => ({});

export const mutations = {};

export const getters = {};

export const actions = {

  index({ commit, dispatch, getters }, { params } = {}) {
    return this.$axios
      .$get("/item", { params: params })
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  getItem({ commit, dispatch, getters }, { id } = {}) {
    return this.$axios
      .$get("/item/" + id)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  store({ commit, dispatch, getters }, { form } = {}) {
    return this.$axios
      .$post("/item", form)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  update({ commit, dispatch, getters }, { id, form } = {}) {
    return this.$axios
      .$post("/item/" + id, form)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },

  getListItem({ commit, dispatch, getters }, { } = {}) {
    return this.$axios
      .$get("/item/list")
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },
};

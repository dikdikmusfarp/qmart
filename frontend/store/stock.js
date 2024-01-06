export const state = () => ({});

export const mutations = {};

export const getters = {};

export const actions = {
  store({ commit, dispatch, getters }, { form } = {}) {
    return this.$axios
      .$post("/stock", form)
      .then((res) => {
        return Promise.resolve(res);
      })
      .catch(function (error) {
        return Promise.reject(error);
      });
  },
};

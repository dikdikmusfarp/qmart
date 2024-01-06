// import Swal from "sweetalert2";
// import axios from 'axios';


export default function ({ $axios, store }) {
    // $axios.defaults.baseURL = 'http://localhost:8000/api'; // Replace with your Laravel API URL
  
    // $axios.onRequest(async (config) => {
    //   try {
    //     config.headers.Authorization = store.state.auth.token;
    //   } catch (error) {
    //     console.log("Could not update token:", error);
    //   }
    //   return config;
    // });
  
    // $axios.onError((error) => {
    //   if (error.response.status === 401) {
    //     sessionStorage.removeItem("auth.token");
    //     sessionStorage.removeItem("auth.currentUser");
    //     sessionStorage.removeItem("auth.userType");
    //     localStorage.removeItem("auth.token");
    //     localStorage.removeItem("auth.currentUser");
    //     localStorage.removeItem("auth.userType");
    //     localStorage.removeItem("auth.userPositionType");
    //     // Swal.fire({
    //     //   icon: "error",
    //     //   title: "Mohon Maaf!",
    //     //   text: "Harap Login terlebih dahulu",
    //     //   showConfirmButton: true,
    //     //   allowOutsideClick: false,
    //     // }).then(function () {
    //     //   window.location.href = '/landing';
    //     // });
    //   }
    // });
  
    // $axios.interceptors.response.use(
    //   function (response) {
    //     return response;
    //   },
    //   function (error) {
    //     // if (error.response.status == 403) {
    //     //   store.dispatch("layout/changeLoaderOverlayValue", { loader: false });
    //     //   window.location = "/utility/403";
    //     // } else if (error.response.status == 422) {
    //     //   store.dispatch("layout/changeLoaderOverlayValue", { loader: false });
    //     //   if (error.response.data.detail) {
    //     //     Swal.fire({
    //     //       type: "error",
    //     //       icon: "error",
    //     //       title: "Validasi Error",
    //     //       text: error.response.data.detail,
    //     //       confirmButtonColor: "#0d642f",
    //     //       confirmButtonText: "OK",
    //     //       showCancelButton: false,
    //     //       showDenyButton: false,
    //     //     });
    //     //   } else {
    //     //     Swal.fire({
    //     //       type: "error",
    //     //       icon: "error",
    //     //       title: "Validasi Error",
    //     //       text: error.response.data.message,
    //     //       confirmButtonColor: "#0d642f",
    //     //       confirmButtonText: "OK",
    //     //       showCancelButton: false,
    //     //       showDenyButton: false,
    //     //     });
    //     //   }
    //     // } else if (error.response.status == 500) {
    //     //   store.dispatch("layout/changeLoaderOverlayValue", { loader: false });
    //     //   Swal.fire({
    //     //     type: "error",
    //     //     icon: "error",
    //     //     title: "Kesalahan",
    //     //     text: error.response.data.error,
    //     //     confirmButtonColor: "#0d642f",
    //     //     confirmButtonText: "OK",
    //     //     showCancelButton: false,
    //     //     showDenyButton: false,
    //     //   });
    //     // } else if (error.response.status == 401) {
    //     //   if (cookies.get('sso-siterdidik-user')) {
    //     //     cookies.remove('sso-siterdidik-user')
    //     //     window.location.href = 'https://disdik.jabarprov.go.id/siterdidik/api/logout'
    //     //   } else {
    //     //     sessionStorage.removeItem("auth.token");
    //     //     sessionStorage.removeItem("auth.currentUser");
    //     //     sessionStorage.removeItem("auth.userType");
    //     //     localStorage.removeItem("auth.token");
    //     //     localStorage.removeItem("auth.currentUser");
    //     //     localStorage.removeItem("auth.userType");
    //     //     localStorage.removeItem("auth.userPositionType");
    //     //     Swal.fire({
    //     //       icon: "error",
    //     //       title: "Mohon Maaf!",
    //     //       text: "Harap Login terlebih dahulu",
    //     //       showConfirmButton: true,
    //     //       allowOutsideClick: false,
    //     //     }).then(function () {
    //     //       window.location.href = '/landing';
    //     //     });
    //     //   }
    //     // } else if (error.response.status == 419) {
    //     //   Swal.fire({
    //     //     icon: "error",
    //     //     title: "Mohon maaf sesi anda telah berakhir",
    //     //     text: "Klik tombol di bawah untuk menyegarkan halaman ini.",
    //     //     showConfirmButton: true,
    //     //     allowOutsideClick: false,
    //     //   }).then(function () {
    //     //     window.location.reload();
    //     //   });
    //     // }
  
    //     return Promise.reject(error);
    //   }
    // );
  }
  
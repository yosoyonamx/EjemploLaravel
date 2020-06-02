require("./bootstrap");

const Vue = require("vue");
const axios = require("axios");
const Swal = require("sweetalert2");

const app = new Vue({
    el: "#app",
    data: {
        add: {
            name: ""
        },
        up: {
            id: "",
            name: ""
        },
        pagination: {
            total: 0,
            current_page: 0,
            per_page: 0,
            last_page: 0,
            from: 0,
            to: 0
        },
        nameSearch: "",
        offset: 3,
        arrayCategory: []
    },
    methods: {
        formPrueba: async function(){
           const { value: formPrueba } =  await Swal.fire({
                title: 'Enviar para Agregadar',
                html:
                  '<input id="swal-input1" class="swal2-input">' +
                  '<input id="swal-input2" class="swal2-input">',
                focusConfirm: false,
                preConfirm: () => {
                   return {
                      text : document.getElementById('swal-input1').value,
                      mensaje : document.getElementById('swal-input2').value
                   }
                }
              });
              if(formPrueba){
                  console.log(formPrueba);
              }
        },
        formAdd: async function() {
            await Swal.fire({
                title: "Agregar Nueva Categoria",
                input: "text",
                inputPlaceholder: "Nombre",
                showCancelButton: true,
                inputValidator: value => {
                    return new Promise(resolve => {
                        if (!value) {
                            resolve("Necesitas escribir un nombre");
                        } else {
                            this.add.name = value;
                            axios.get(`category/${value}/edit`).then(res => {
                                if (res.data.length) {
                                    resolve(`Categorio: ${value}, ya existe`);
                                } else {
                                    resolve();
                                }
                            });
                        }
                    });
                },
                preConfirm: () => {
                    this.addCategory();
                }
            });
        },
        formEdit: async function(item) {
            this.up = {
                id: item.id,
                name: item.name
            };
            await Swal.fire({
                title: "Agregar Nueva Categoria",
                input: "text",
                inputValue: this.up.name,
                inputPlaceholder: "Nombre",
                showCancelButton: true,
                inputValidator: value => {
                    return new Promise(resolve => {
                        if (!value) {
                            resolve("Necesitas escribir un nombre");
                        } else {
                            this.up.name = value;
                            if (item.name == value) {
                                resolve();
                            } else {
                                axios
                                    .get(`category/${value}/edit`)
                                    .then(res => {
                                        if (res.data.length) {
                                            resolve(
                                                `Categorio: ${value}, ya existe`
                                            );
                                        } else {
                                            resolve();
                                        }
                                    });
                            }
                        }
                    });
                },
                preConfirm: () => {
                    this.upCategory();
                }
            });
        },
        formDelete: async function(id) {
            await Swal.fire({
                title: "¿Seguro de eliminarlo?",
                text: "Esta accion es irreversible",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, borralo!"
            }).then(result => {
                if (result.value) {
                    this.deleteCategory(id);
                    Swal.fire(
                        "Borrado!",
                        "Despues no te quejes :D.",
                        "success"
                    );
                }
            });
        },
        // PAGINATION
        changePage: function(page) {
            this.pagination.current_page = page;
            this.listCategory(page);
        },

        // CRUD
        listCategory: function(page) {
            axios
                .get(`category?page=${page}&search=${this.nameSearch}`)
                .then(res => {
                    this.arrayCategory = res.data.category.data;
                    this.pagination = res.data.pagination;
                });
        },
        addCategory: function() {
            axios
                .post("category", { name: this.add.name })
                .then(res => {
                    this.add.name = "";
                    Swal.fire("Agregado!", "Todo en orden.", "success");
                    this.listCategory(1);
                })
                .catch(err => {
                    Swal.fire(
                        "Oppsss!",
                        "No puedes repetir el nombre",
                        "error"
                    );
                });
        },
        upCategory: function() {
            axios
                .put(`category/${this.up.id}`, { name: this.up.name })
                .then(res => {
                    this.up = {
                        id: "",
                        name: ""
                    };
                    Swal.fire("Actualizado!", "Todo en orden ;D", "success");
                    this.listCategory(1);
                })
                .catch(err => {
                    Swal.fire(
                        "Oppsss!",
                        "No puedes repetir el nombre",
                        "error"
                    );
                });
        },
        deleteCategory: function(id) {
            axios.delete(`category/${id}`).then(res => {
                this.listCategory(1);
            });
        }
    },
    computed: {
        isActived: function() {
            return this.pagination.current_page;
        },
        pagesNumber: function() {
            if (!this.pagination.to) {
                return [];
            }

            var from = this.pagination.current_page - this.offset; //1000 offset
            if (from < 1) {
                from = 1;
            }

            var to = from + this.offset * 2; //1000 offset
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    created: function() {
        this.listCategory();
    }
});

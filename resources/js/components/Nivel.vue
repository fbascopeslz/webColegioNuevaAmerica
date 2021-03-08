<template>
    <main class="main">     
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Niveles
                    <button type="button" @click="abrirModal('registrar')" class="btn btn-secondary">
                        <i class="fa fa-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="Nombre">Nombre</option>                                  
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarNiveles(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarNiveles(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>                            
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="nivel in arrayNiveles" :key="nivel.id">
                                <td>
                                    <button type="button" @click="abrirModal('actualizar', nivel)" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </button> &nbsp;                                
                                </td>
                                <td v-text="nivel.Nombre"></td>                                                                                                                                                   
                            </tr>                           
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                            </li>

                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                            </li>       

                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

        <!--Inicio del modal agregar/actualizar-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                
                    <div class="modal-body">

                        <form method="post" enctype="multipart/form-data" class="form-horizontal">                        
                            
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre del Nivel</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre Nivel">
                                    <span class="help-block">(*) Ingrese el Nombre del Nivel</span>
                                </div>
                            </div>                           
                                                    
                            <div v-show="errorNivel == 1" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjNivel" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>                                         
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-primary" @click="registrarNivel()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-primary" @click="actualizarNivel()">Actualizar</button>
                    </div>                             

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    
    </main>
</template>

<script>
  
    import Vue from 'vue';
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    // Init plugin
    Vue.use(Loading);


    export default {                  
        data() {
            return {               
                idNivel: 0,
                nombre: '',

                arrayNiveles: [],

                modal: 0,
                tituloModal: '',

                tipoAccion: 0,

                //variable para los errores
                //bandera para ver si encontro error
                errorNivel: 0,
                //Array con los errores encontrados
                errorMostrarMsjNivel: [],

                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,

                //Busqueda
                criterio: 'Nombre',
                buscar: '',

            }
        },

        //propiedades computadas
        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },

            //Calcula los elementos de la paginacion
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
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

        methods: {
            //Validar que el input solo acepte numeros y punto
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },
            
            
            listarNiveles(page, buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                var url = 'nivel?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayNiveles = respuesta.niveles.data;
                        me.pagination = respuesta.pagination;
                        
                        loader.hide();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);

                        loader.hide();
                    })
                    .then(function () {
                        // always executed
                    });
            },

            cambiarPagina(page, buscar, criterio) {
                let me = this;

                //Actualizar la pagina actual
                me.pagination.current_page = page;

                //Envia la peticion para visualizar la data de esa pagina
                me.listarNiveles(page, buscar, criterio);
            },

            registrarNivel() {                
                //Verificar las validaciones
                if (this.validarNivel()) {
                    return;
                }

                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;                                       

                axios.post(
                    'nivel/registrar',
                    {                        
                        'Nombre': this.nombre,                        
                    }                    
                ).then(function (response) {   
                    loader.hide();

                    me.cerrarModal();
                    me.listarNiveles(1, '', 'Nombre');
                    
                    console.log(response);
                }).catch(function (error) {
                    console.log(error);

                    loader.hide();                                        
                });
            },

            actualizarNivel() {
                //Verificar las validaciones
                if (this.validarNivel()) {
                    return;
                }

                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
            
                axios.post(
                    'nivel/actualizar',
                    {
                        'id': this.idNivel,                        
                        'Nombre': this.nombre                                            
                    }                                    
                ).then(function (response) {
                    loader.hide();

                    me.cerrarModal();
                    me.listarNiveles(1, '', 'Nombre');
                    
                    console.log(response);

                }).catch(function (error) {
                    console.log(error);

                    loader.hide();
                });
                
            },

            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';

                this.idNivel = 0;                
                this.nombre = '';                        
                               
                //limpiar las validaciones
                this.errorNivel = 0;
                this.errorMostrarMsjNivel = [];
            },

            abrirModal(accion, data = []) {              
                switch (accion) {
                    case "registrar":
                        this.modal = 1;
                        this.tituloModal = "Registrar Nivel";
                        this.tipoAccion = 1;

                        this.idNivel = 0;                        
                        this.nombre = '';                                                                                                                  
                        break;

                    case "actualizar":                                                    
                        this.modal = 1;
                        this.tituloModal = 'Actualizar Nivel';
                        this.tipoAccion = 2;

                        this.idNivel = data['Id'];                        
                        this.nombre = data['Nombre'];                                           
                        break;
                
                    default:
                        break;
                }                                
            },

            validarNivel() {
                this.errorNivel = 0;                
                this.errorMostrarMsjNivel = [];

                if (!this.nombre) {
                    this.errorMostrarMsjNivel.push("El campo Nombre no puede estar vacio.");
                }                              
                
                if (this.errorMostrarMsjNivel.length) {
                    this.errorNivel = 1;
                }

                return this.errorNivel;
            },                        

        },
       
        mounted() {
            //console.log('Component mounted.')
            this.listarNiveles(1, this.buscar, this.criterio);                        
        }
    }
    
</script>

<style>
    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3C29297A !important;
    }

    .div-error {
        display: flex;
        justify-content: center;        
    }
    .text-error {
        color: red !important;
        font-weight: bold;
    }

</style>
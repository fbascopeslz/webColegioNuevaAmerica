<template>
    <main class="main">     
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Boletin de Notas
                    <button v-show="swBotonGenerarBoletin == 1" type="button" @click="generarBoletinNotas()" class="btn btn-secondary">
                        <i class="fa fa-plus"></i>&nbsp;Generar Boletin Notas
                    </button>                
                </div>

                <div class="card-body">                
                    <div class="form-row form-group border">
                        <div class="col-md-12 form-group">
                            <label>Seleccione una Oferta: </label>
                        </div>                                                      
                        <div class="form-group col-md-6">                                        
                            <label>Materia</label>                                                                                  
                            <input type="text" readonly class="form-control" v-model="materiaOferta">                                                                                                                                                                                                                                              
                        </div> 
                        <div class="form-group col-md-6">                                    
                            <label>Profesor</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="profesorOferta">                                                                                                                                                                                                                         
                        </div>
                        <div class="form-group col-md-4">                                    
                            <label>Curso</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="cursoOferta">                                                                                                                                                                                                                         
                        </div>
                        <div class="form-group col-md-2">                                    
                            <label>Paralelo</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="paraleloOferta">                                                                                                                                                                                                                         
                        </div> 
                        <div class="form-group col-md-6">                                    
                            <label>Nivel</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="nivelOferta">                                                                                                                                                                                                                         
                        </div>                        
                        <div class="form-group col-md-2">                                
                            <div class="form-inline">                                                                               
                                <button @click="abrirModal('oferta')" class="btn btn-primary form control btnbuscar">Seleccionar Oferta</button>                                        
                            </div>                                
                        </div>                                                                                                                                                                                                                                                                                                              
                    </div>                                                                             
                </div>

            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

        <!--Modal para Oferta-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modalOferta}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioOferta">                                        
                                        <option value="Materia.Nombre">Materia</option>                                                                                                                    
                                    </select>
                                    <input type="text" v-model="buscarOferta" @keyup.enter="listarOfertas(buscarOferta, criterioOferta)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarOfertas(buscarOferta, criterioOferta)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                <span>(*)Para visualizar todas los Ofertas haga una busqueda en blanco</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Profesor</th>
                                        <th>Materia</th>                                        
                                        <th>Curso</th>                               
                                        <th>Paralelo</th>
                                        <th>Nivel</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(oferta, index) in arrayOfertas" :key="index">
                                        <td>
                                            <button type="button" @click="seleccionarOferta(oferta)" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button> 
                                        </td>
                                        <td v-text="oferta.Profesor"></td>
                                        <td v-text="oferta.Materia"></td>                                        
                                        <td v-text="oferta.Curso"></td>
                                        <td v-text="oferta.Paralelo"></td>
                                        <td v-text="oferta.Nivel"></td>                                    
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscarOferta, criterioOferta, 'oferta')">Ant</a>
                                </li>

                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscarOferta, criterioOferta, 'oferta')" v-text="page"></a>
                                </li>       

                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscarOferta, criterioOferta, 'oferta')">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>                        
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
                idOferta: 0,
                materiaOferta: '',                                
                profesorOferta: '',
                cursoOferta: '',
                paraleloOferta: '',
                nivelOferta: '',                                           
                arrayOfertas: [],
                //Para la busqueda en el modal Oferta
                criterioOferta: 'Materia.Nombre',
                buscarOferta: '',
                modalOferta: 0,

                //switches                                
                swBotonGenerarBoletin: 0,

                tituloModal: '',
                

                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,            
                //opciones para Vue loading overlay        
                optionsLoadingOverlay : {                        
                    canCancel: false,
                    color: '#007BFF',
                    height:	128,
                    width: 128
                },
                                               
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
            },

        },

        methods: {                          
            //Validar que el input solo acepte numeros y punto
            isNumberDecimal: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },

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

            cambiarPagina(page, buscar, criterio, tipo) {
                let me = this;
                switch (tipo) {                                       
                    case 'oferta':
                        //Actualizar la pagina actual
                        me.pagination.current_page = page;
                        //Envia la peticion para visualizar la data de esa pagina
                        me.listarOfertas(page, buscar, criterio);
                        break;
                
                    default:
                        break;
                }                                
            },        

            listarOfertas(page, buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;                
                var url = 'oferta3?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayOfertas = respuesta.ofertas.data;
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

            seleccionarOferta(oferta) {                            
                this.idOferta = oferta.Id;
                this.materiaOferta = oferta.Materia;
                this.profesorOferta = oferta.Profesor;
                this.cursoOferta = oferta.Curso;
                this.paraleloOferta = oferta.Paralelo;
                this.nivelOferta = oferta.Nivel;
                //Hacer visible el boton de Generar Boletin
                this.swBotonGenerarBoletin = 1;
                this.cerrarModal();                    
            },

            abrirModal(accion) {
                //resetear la paginacion
                this.pagination = {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                };

                switch (accion) {                                                            
                    case 'oferta':
                        this.arrayOfertas = [];                             
                        this.modalOferta = 1;
                        this.tituloModal = "Seleccione una Oferta";
                        //Llenar array Alumno
                        this.listarOfertas(1, this.buscarOferta, this.criterioOferta); 
                        break;
                
                    default:
                        break;
                }
                
            },

            cerrarModal() {                                
                this.modalOferta = 0;
                this.tituloModal = '';                
            },



            generarBoletinNotas() {
                window.open('boletinNotas', '_blank');
            },
           
                                                    
        },
       
        mounted() {
            //console.log('Component mounted.');                              
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

    .preview {
        width: 100px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
    }

    .div-error {
        display: flex;
        justify-content: center;        
    }
    .text-error {
        color: red !important;
        font-weight: bold;
    }

    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
        .btnbuscar {
            margin-top: 2rem;
        }        
        .btnAgregarOferta {
            margin-top: 5px;
        }
    }

</style>
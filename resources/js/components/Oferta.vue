<template>
    <main class="main">     
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Oferta                    
                </div>

                <div class="card-body">
                    <div class="form-row form-group">
                        <label>Seleccione un Profesor: </label>
                    </div>                                           
                    
                    <div class="form-row form-group border">                                                        
                        <div class="form-group col-md-3">                                        
                            <label>Nombre</label>                                                                                  
                            <input type="text" readonly class="form-control" v-model="nombreProfesor">                                                                                                                                                                                                                                              
                        </div> 
                        <div class="form-group col-md-3">                                    
                            <label>CI</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="ciProfesor">                                                                                                                                                                                                                         
                        </div>
                        <div class="form-group col-md-3">                                                                       
                            <label>Sexo</label>                                           
                            <input type="text" readonly value="0" class="form-control" v-model="sexoProfesor">                                                                                                                                                             
                        </div>
                        <div class="form-group col-md-2">                                
                            <div class="form-inline">                                                                               
                                <button @click="abrirModal('profesores')" class="btn btn-primary form control btnbuscar">Seleccionar Profesor</button>                                        
                            </div>                                
                        </div>                                                                                                                                                                                                                                                                                                              
                    </div>


                    <div class="form-row form-group border">
                        <div class="form-group col-md-3" v-show="swModalAgregarOferta == 1">
                            <div class="form-inline">
                                <button type="button" @click="abrirModal('agregarOferta')" class="btn btn-secondary form control btnAgregarOferta">
                                    <i class="fa fa-plus"></i>&nbsp;Añadir Oferta
                                </button>
                            </div>
                        </div>

                        <div class="form-group table-responsive col-md-12">                    
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>                                        
                                        <th>Nivel</th>                                        
                                        <th>Curso</th>
                                        <th>Paralelo</th>                                                                                                                                                                                                                      
                                        <th>Materia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="oferta in arrayOfertas" :key="oferta.id">                                        
                                        <td v-text="oferta.Nivel"></td>
                                        <td v-text="oferta.Curso"></td>
                                        <td v-text="oferta.Paralelo"></td>
                                        <td v-text="oferta.Materia"></td>                                                                                                                                                                                                                                                                                                                     
                                    </tr>                            
                                </tbody>
                            </table>
                        </div>
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

            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

        <!--Modal para Profesores-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modalProfesor}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
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
                                    <select class="form-control col-md-3" v-model="criterioProfesor">                                        
                                        <option value="Nombre">Nombre</option>
                                        <option value="CI">CI</option>                                                                                
                                    </select>
                                    <input type="text" v-model="buscarProfesor" @keyup.enter="listarProfesores(buscarProfesor, criterioProfesor)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProfesores(buscarProfesor, criterioProfesor)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                                </div>
                                <span>(*)Para visualizar todos los Profesores haga una busqueda en blanco</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>CI</th>                                        
                                        <th>Fecha Nacimiento</th>                               
                                        <th>Sexo</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(profesor, index) in arrayProfesor" :key="index">
                                        <td>
                                            <button type="button" @click="seleccionarProfesor(profesor)" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button> 
                                        </td>
                                        <td v-text="profesor.Nombre"></td>
                                        <td v-text="profesor.CI"></td>                                        
                                        <td v-text="profesor.FechaNac"></td>
                                        <td v-text="profesor.Sexo"></td>
                                        <td v-text="profesor.Direccion"></td>                                                                    
                                        <td v-text="profesor.Telefono"></td>
                                        <td v-text="profesor.Email"></td>                                      
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
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

        <!--Modal para Agregar Oferta-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modalAgregarOferta}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
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
                            <label class="col-md-3 form-control-label" for="text-input">Seleccione un Nivel:</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idNivel" @change="onChangeSelectNivel($event)">
                                    <option value="0">Seleccione un Nivel</option>
                                    <option v-for="nivel in arrayNivel" :key="nivel.Id" :value="nivel.Id" v-text="nivel.Nombre"></option>
                                </select>
                                <span class="help-block">(*) Seleccione el Nivel educativo</span>
                            </div>                                
                        </div>                        
                        <div class="form-group row" v-show="swCurso == 1">
                            <label class="col-md-3 form-control-label" for="text-input">Seleccione un Curso:</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idCurso" @change="onChangeSelectCurso($event)">
                                    <option value="0">Seleccione un Curso</option>
                                    <option v-for="curso in arrayCurso" :key="curso.Id" :value="curso.Id" v-text="curso.Nombre"></option>
                                </select>
                                <span class="help-block">(*) Seleccione un Curso</span>
                            </div>                                
                        </div>
                        <div class="form-group row" v-show="swParalelo == 1">
                            <label class="col-md-3 form-control-label" for="text-input">Seleccione un Paralelo:</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idParalelo" @change="onChangeSelectParalelo($event)">
                                    <option value="0">Seleccione un Paralelo</option>
                                    <option v-for="paralelo in arrayParalelo" :key="paralelo.Id" :value="paralelo.Id" v-text="paralelo.Nombre"></option>
                                </select>
                                <span class="help-block">(*) Seleccione un Paralelo</span>
                            </div>                                
                        </div>

                        <div class="form-group row border" v-show="swMateria == 1">                                                        
                            <label class="col-md-2 form-control-label" for="text-input">Seleccione una Materia:</label>
                            <div class="col-md-8">                                        
                                <select class="form-control" v-model="idMateria" @change="onChangeSelectMateria($event)">
                                    <option value="0">Seleccione una Materia</option>
                                    <option v-for="materia in arrayMateria" :key="materia.Id" :value="materia.Id" v-text="materia.Nombre"></option>
                                </select>                                
                            </div>                          
                            <div class="col-md-2">                                                                                                                                                                             
                                <button type="button" @click="agregarOferta()" class="btn btn-primary form control">
                                    <i class="fa fa-plus"></i>&nbsp;
                                </button>                                                              
                            </div>

                            <div class="table-responsive col-md-12" v-show="swMateria == 1">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nivel</th>
                                        <th>Curso</th>
                                        <th>Paralelo</th>
                                        <th>Materia</th>
                                    </thead>

                                    <tbody v-if="arrayAgregarOferta.length">
                                        <tr v-for="(agregarOferta, index) in arrayAgregarOferta" :key="index">
                                            <td>
                                                <button @click="quitarOferta(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                            <td v-text="agregarOferta.Nivel"></td>
                                            <td v-text="agregarOferta.Curso"></td>
                                            <td v-text="agregarOferta.Paralelo"></td>
                                            <td v-text="agregarOferta.Materia"></td>                                      
                                        </tr>                                                                                                         
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">No hay Ofertas agregados</td>
                                        </tr>
                                    </tbody>
                                </table>                                                                                                                                                                                                                                                                                                                       
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div v-show="errorAgregarOferta == 1" class="form-group row div-error">
                                <div class="text-center text-error">
                                    Agregue almenos una oferta para guardar cambios
                                </div>
                            </div>
                        </div>

                    </div>                                                
                      
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button v-show="swMateria == 1" type="button" class="btn btn-primary" @click="registrarOferta()">Agregar Ofertas</button>                        
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
                
                idProfesor: 0,
                nombreProfesor: '',                
                ciProfesor: 0,
                sexoProfesor: '',                
                
                arrayOfertas: [],               
                arrayProfesor: [],                
                
                //Busqueda
                criterio: 'Id',
                buscar: '',

                //Nivel
                arrayNivel: [],
                idNivel: 0,
                nombreNivel: '',
                //Curso
                arrayCurso: [],
                idCurso: 0,
                nombreCurso: '',
                //Paralelo
                arrayParalelo: [],
                idParalelo: 0,
                nombreParalelo: '',
                //Materia
                arrayMateria: [],
                idMateria: 0,
                nombreMateria: '',

                //Id CursoParalelo
                idCursoParalelo: 0,

                //Array Agregar Ofertas
                arrayAgregarOferta: [],
                
                //Para la busqueda en el modal Profesor
                criterioProfesor: 'Nombre',
                buscarProfesor: '',
        
                modalProfesor: 0,
                modalAgregarOferta: 0,
                tituloModal: '',

                //switches
                swModalAgregarOferta: 0,
                swCurso: 0,
                swParalelo: 0,
                swMateria: 0,

                //variable para controlar que se agregue almenos una oferta
                errorAgregarOferta: 0,

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

            cambiarPagina(page, buscar, criterio) {
                let me = this;

                //Actualizar la pagina actual
                me.pagination.current_page = page;

                //Envia la peticion para visualizar la data de esa pagina
                me.listarOfertas(page, buscar, criterio);
            },

            listarOfertas(page, buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);             
                var me = this;
                var url = 'oferta?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&idProfesor=' + this.idProfesor;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        //console.log(response);

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

            listarProfesores(buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                var url = 'profesor/getProfesores' + '?buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayProfesor = respuesta.profesores;
                        
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
    
            seleccionarProfesor(profesor) {
                this.idProfesor = profesor.Id;
                this.nombreProfesor = profesor.Nombre;
                this.ciProfesor = profesor.CI;
                this.sexoProfesor = profesor.Sexo;

                //Hacer visible el boton de Agregar Oferta
                this.swModalAgregarOferta = 1;
                
                this.listarOfertas(1, this.buscar, this.criterio);
                this.cerrarModal();
            },
        
            abrirModal(accion) {
                switch (accion) {
                    case 'profesores':
                        this.arrayProfesor = [];                             
                        this.modalProfesor = 1;
                        this.tituloModal = "Seleccione un Profesor";

                        //Llenar array Profesor
                        this.listarProfesores('', 'Nombre');
                        break;

                    case 'agregarOferta':
                        this.arrayNivel = [];
                        this.idNivel = 0;
                        this.nombreNivel = '';
                        this.arrayCurso = [];
                        this.idCurso = 0;
                        this.nombreCurso = '';
                        this.arrayParalelo = [];
                        this.idParalelo = 0;
                        this.nombreParalelo = '';
                        this.arrayMateria = [];
                        this.idMateria = 0;
                        this.nombreMateria = '';

                        this.arrayAgregarOferta = [];
                        
                        this.swCurso = 0;
                        this.swParalelo = 0;
                        this.swMateria = 0;

                        this.modalAgregarOferta = 1;
                        this.tituloModal = "Agregar Oferta";

                        //Llenar array Nivel
                        this.listarNiveles();
                        break;
                
                    default:
                        break;
                }
                
            },

            cerrarModal() {
                this.modalProfesor = 0;
                this.modalAgregarOferta = 0;
                this.tituloModal = '';                
            },


            listarNiveles() {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                var url = 'nivel/getNiveles';
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayNivel = respuesta.niveles;
                        
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

            listarCursos() {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                var url = 'curso/getCursos?idNivel=' + this.idNivel;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayCurso = respuesta.cursos;
                        
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

            listarParalelos() {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                var url = 'paralelo/getParalelos?idNivel=' + this.idNivel + '&idCurso=' + this.idCurso;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayParalelo = respuesta.paralelos;
                        
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

            listarMaterias() {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                var url = 'materia/getMaterias?idNivel=' + this.idNivel + '&idCurso=' + this.idCurso + '&idParalelo=' + this.idParalelo + '&idProfesor=' + this.idProfesor;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayMateria = respuesta.materias;

                        me.idCursoParalelo = respuesta.idCursoParalelo;
                        
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

            registrarOferta() {   
                //Verificar que se agregue almenos una oferta
                if (this.arrayAgregarOferta.length == 0) {
                    this.errorAgregarOferta = 1;
                    return;
                }                
                
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;                                       

                axios.post(
                    'oferta/registrar',
                    {                        
                        'arrayOfertas': this.arrayAgregarOferta,                        
                    }                    
                ).then(function (response) {
                    loader.hide();
                                                        
                    me.cerrarModal();                    
                    me.listarOfertas(1, me.buscar, me.criterio);

                    console.log(response);

                }).catch(function (error) {
                    console.log(error);

                    loader.hide();
                });
            },


            buscarNombreById(array, id) {
                for (let i = 0; i < array.length; i++) {                    
                    if (array[i].Id == id) {
                        return array[i].Nombre
                    }                    
                }
                return '';
            },

            onChangeSelectNivel(event) {                               
                //console.log(event.target.value);
                
                this.nombreNivel = this.buscarNombreById(this.arrayNivel, this.idNivel);

                this.swCurso = 1;
                this.idCurso = 0;
                this.arrayCurso = [];
                this.listarCursos();
            },

            onChangeSelectCurso(event) {
                //console.log(event.target.value);

                this.nombreCurso = this.buscarNombreById(this.arrayCurso, this.idCurso);

                this.swParalelo = 1;
                this.idParalelo = 0;
                this.arrayParalelo = [];
                this.listarParalelos();
            },

            onChangeSelectParalelo(event) {
                //console.log(event.target.value);

                this.nombreParalelo = this.buscarNombreById(this.arrayParalelo, this.idParalelo);
                
                this.swMateria = 1;
                this.idMateria = 0;
                this.arrayMateria = [];
                this.listarMaterias();
            },

            onChangeSelectMateria(event) {
                //console.log(event.target.value);

                this.nombreMateria = this.buscarNombreById(this.arrayMateria, this.idMateria);                                                
            },

            buscarIndiceById(array, id) {
                for (let i = 0; i < array.length; i++) {                    
                    if (array[i].Id == id) {
                        return i;
                    }                    
                }
                return 0;
            },

            agregarOferta() {
                this.errorAgregarOferta = 0;

                //Agregar al array de Oferta y mostrar en la tabla
                this.arrayAgregarOferta.push({
                    'MateriaId': this.idMateria,
                    'ProfesorId': this.idProfesor,
                    'CursoParaleloId': this.idCursoParalelo,
                    'Nivel': this.nombreNivel,
                    'Curso': this.nombreCurso,
                    'Paralelo': this.nombreParalelo,
                    'Materia': this.nombreMateria                    
                });

                this.idMateria = 0;

                //Quitar del array de Materias esa materia
                var indice = this.buscarIndiceById(this.arrayMateria, this.idMateria);
                this.arrayMateria.splice(indice, 1);
            },
            
            quitarOferta(index) {
                //Agregar al array de Materias
                this.arrayMateria.push({
                    'Id': this.arrayAgregarOferta[index].MateriaId,
                    'Nombre': this.arrayAgregarOferta[index].Materia
                });

                //Quitar del array de AgregarOferta
                this.arrayAgregarOferta.splice(index, 1);
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
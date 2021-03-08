<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>            
        </ol>

        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Alumnos
                    <button type="button" @click="abrirModal('registrar')" class="btn btn-secondary">
                        <i class="fa fa-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="Alumno.Nombre">Nombre</option>
                                    <option value="Alumno.CI">CI</option>
                                    <option value="Alumno.Email">Email</option>                                   
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarAlumnos(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarAlumnos(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>CI</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Sexo</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Usuario</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="alumno in arrayAlumnos" :key="alumno.id">
                                <td>
                                    <button type="button" @click="abrirModal('actualizar', alumno)" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </button> &nbsp;                                
                                </td>
                                <td v-text="alumno.Nombre"></td>
                                <td v-text="alumno.CI"></td>
                                <td v-text="alumno.FechaNac"></td>
                                <td v-text="alumno.Sexo"></td>
                                <td v-text="alumno.Direccion"></td>
                                <td v-text="alumno.Telefono"></td>
                                <td v-text="alumno.Email"></td>
                                <td v-text="alumno.Usuario"></td>
                                <td><img class="preview" :src="'https://notascolegio.azurewebsites.net/api/images/' + alumno.Fotografia"></td>                                                                                                                                                     
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
                                <label class="col-md-3 form-control-label" for="text-input">Nombre Completo</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre Completo">
                                    <span class="help-block">(*) Ingrese el Nombre completo del alumno</span>
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">CI</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="ci" @keypress="isNumber($event)" class="form-control" placeholder="Numero Carnet de identidad">
                                    <span class="help-block">(*) Ingrese el Numero de CI del alumno</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">FechaNac</label>
                                <div class="col-md-9">
                                    <input type="date" v-model="fechaNac" class="form-control" placeholder="Fecha de nacimiento">                                    
                                </div>
                            </div>                          
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Sexo</label>
                                <div class="col-md-9">
                                    <select v-model="sexo" class="form-control">
                                        <option value="M">M</option>
                                        <option value="F">F</option>                                       
                                    </select>
                                    <span class="help-block">(*) Seleccione el sexo del Alumno</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Direccion">                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" @keypress="isNumber($event)" class="form-control" placeholder="Telefono">                                    
                                </div>
                            </div>      
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Email">                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Usuario</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="usuario" class="form-control" placeholder="Usuario">                                    
                                    <span class="help-block">(*) Ingrese el Usuario o Nickname del Usuario</span>
                                </div>                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Password</label>
                                <div class="col-md-9">
                                    <input type="password" v-model="password" class="form-control" placeholder="Password de acceso">                                    
                                    <span class="help-block">(*) Ingrese el Password del Usuario</span>
                                </div>                                
                            </div>
                                                    
                            <div v-show="errorAlumno == 1" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjAlumno" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>                                         
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-primary" @click="registrarAlumno()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-primary" @click="actualizarAlumno()">Actualizar</button>
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
                idAlumno: 0,
                ci : 0,
                nombre: '',
                fechaNac: '',
                sexo: 'M',
                telefono: '',
                email: '',                
                direccion: '',

                usuario: '',
                password: '',                
                

                arrayAlumnos: [],

                modal: 0,
                tituloModal: '',

                tipoAccion: 0,

                //variable para los errores
                //bandera para ver si encontro error
                errorAlumno: 0,
                //Array con los errores encontrados
                errorMostrarMsjAlumno: [],

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
                criterio: 'Alumno.Nombre',
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
            
            
            listarAlumnos(page, buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                //http://www.saparicio.xyz/webColegioNuevaAmerica/public/alumno?page=1&buscar=&criterio=Alumno.Nombre
                var url = 'alumno?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayAlumnos = respuesta.alumnos.data;
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
                me.listarAlumnos(page, buscar, criterio);
            },

            registrarAlumno() {                
                //Verificar las validaciones
                if (this.validarAlumno()) {
                    return;
                }

                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;                                       

                axios.post(
                    'alumno/registrar',
                    {
                        'ci': this.ci,
                        'nombre': this.nombre,
                        'fechaNac': this.fechaNac,
                        'sexo': this.sexo,
                        'direccion': this.direccion,
                        'telefono': this.telefono,
                        'email': this.email,
                        'usuario': this.usuario,
                        'password': this.password
                    }              
                ).then(function (response) {                        
                    loader.hide();

                    me.cerrarModal();
                    me.listarAlumnos(1, '', 'Alumno.Nombre');
                    
                    console.log(response);
                }).catch(function (error) {
                    console.log(error);

                    loader.hide();                                     
                });
            },

            actualizarAlumno() {
                //Verificar las validaciones
                if (this.validarAlumno()) {
                    return;
                }

                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
            
                axios.post(
                    'alumno/actualizar',
                    {
                        'id': this.idAlumno,
                        'ci': this.ci,
                        'nombre': this.nombre,
                        'fechaNac': this.fechaNac,
                        'sexo': this.sexo,
                        'direccion': this.direccion,
                        'telefono': this.telefono,
                        'email': this.email,
                        'usuario': this.usuario,
                        'password': this.password                  
                    }                                    
                ).then(function (response) {
                    loader.hide();

                    me.cerrarModal();
                    me.listarAlumnos(1, '', 'Alumno.Nombre');
                    
                    console.log(response);

                }).catch(function (error) {
                    console.log(error);

                    loader.hide();
                });
                
            },

            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';

                this.idAlumno = 0;
                this.ci = 0;
                this.nombre = '';
                this.fechaNac = '';
                this.sexo = 'M';
                this.direccion = '';
                this.telefono = '';
                this.email = '';
                
                this.usuario = '';
                this.password = '';
                               
                //limpiar las validaciones
                this.errorAlumno = 0;
                this.errorMostrarMsjAlumno = [];
            },

            abrirModal(accion, data = []) {              
                switch (accion) {
                    case "registrar":
                        this.modal = 1;
                        this.tituloModal = "Registrar alumno";
                        this.tipoAccion = 1;

                        this.idAlumno = 0;
                        this.ci = 0;
                        this.nombre = '';
                        this.fechaNac = '';
                        this.sexo = 'M';
                        this.direccion = '';
                        this.telefono = '';
                        this.email = '';
                        
                        this.usuario = '';
                        this.password = '';

                        break;

                    case "actualizar":                                                    
                        this.modal = 1;
                        this.tituloModal = 'Actualizar alumno';
                        this.tipoAccion = 2;

                        console.log(data);

                        this.idAlumno = data['Id'];
                        this.ci = data['CI'];
                        this.nombre = data['Nombre'];
                        this.fechaNac = data['FechaNac'];
                        this.sexo = data['Sexo'];
                        this.direccion = data['Direccion'];
                        this.telefono = data['Telefono'];
                        this.email = data['Email'];
                        
                        this.usuario = data['Usuario'];                        

                        break;
                
                    default:
                        break;
                }                                
            },

            validarAlumno() {
                this.errorAlumno = 0;                
                this.errorMostrarMsjAlumno = [];

                if (this.ci == 0) {
                    this.errorMostrarMsjAlumno.push("El campo CI no puede estar vacio.");
                }

                if (!this.nombre) {
                    this.errorMostrarMsjAlumno.push("El campo Nombre no puede estar vacio.");
                }

                if (!this.fechaNac) {
                    this.errorMostrarMsjAlumno.push("El campo Fecha de Nacimiento no puede estar vacio.");
                }

                if (!this.direccion) {
                    this.errorMostrarMsjAlumno.push("El campo Direccion no puede estar vacio.");
                }
                
                if (!this.telefono) {
                    this.errorMostrarMsjAlumno.push("El campo Telefono no puede estar vacio.");
                }

                if (!this.email) {
                    this.errorMostrarMsjAlumno.push("El campo Email no puede estar vacio.");
                }                                                
                
                if (!this.usuario) {
                    this.errorMostrarMsjAlumno.push("El campo Usuario no puede estar vacio.");
                }

                if (!this.password) {
                    this.errorMostrarMsjAlumno.push("El campo Password no puede estar vacio.");
                }

                if (this.errorMostrarMsjAlumno.length) {
                    this.errorAlumno = 1;
                }

                return this.errorAlumno;
            },                        

        },
       
        mounted() {
            //console.log('Component mounted.')
            this.listarAlumnos(1, this.buscar, this.criterio);                        
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

    img.preview {
        width: 150px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
    }

</style>
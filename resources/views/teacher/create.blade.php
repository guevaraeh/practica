@extends('layout')

@section('title')
<title>Crear Profesor</title>
@endsection

@section('content')
<div class="container">
            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Crear profesor</h6>
                </div>
                <div class="card-body">
                  <form action="{{ route('teacher.store') }}" method="POST">
                  	@csrf
                    <div class="mb-3">
                      <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                          <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                          <input type="text" class="form-control" id="exampleFirstName" name="name">
                        </div>
                        <div class="col-sm-6">
                          <label for="exampleFormControlInput1" class="form-label">Apellido</label>
                          <input type="text" class="form-control" id="exampleLastName" name="lastname">
                        </div>
                      </div>
                    </div>

                    <div class="mb-3">
                      <button type="submit" class="btn btn-primary">Crear</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>
@endsection

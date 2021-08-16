<style>
    .titulo {
      text-align: center;
      border: 3px solid green;
      font-family: Tahoma, Verdana, sans-serif;
      border-radius: 15px;
    },
    .sub-titulo {
      font-size: 25px;
    },
    .dados {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 20px;
      margin-top: 15px;
    },
  
  
    
</style>
<div >
  <h1 class="titulo">Responsabilidades e Autorizações</h1>
  <hr>
  <div class="nome">
    <p class="dados"><strong>Nome do Colaborador:</strong> {{$responsa_auto->colaborador->nome}}</p>
  </div>
  <div>
      <p class="dados"><strong>Nome do Autorizador:</strong> {{$responsa_auto->autorizador->nome}}</p>
  </div>
  <div>
    <div>
      <p class="dados"><strong>Cargo:</strong> {{$responsa_auto->cargo->cargo}}</p>
  </div>
    @if($responsa_auto->responsabilidades != '')
    @php
      $responsabilidades = json_decode($responsa_auto->responsabilidades)    
    @endphp
      <p class="dados"><strong> Responsabilidades: </strong></p>
      <ol>
        @foreach ($responsabilidades as $item)
          <li class="dados">{{ $item }}</li>
        @endforeach
      </ol>
    @endif
  </div>
 
  <div style="text-align: center">
    <h4 class="sub-titulo">Assinatura autorizador:</h4>
    <p class="dados">{{$responsa_auto->assinatura_autorizador}}</p>
    <hr>
  </div>
  <div style="text-align: center">
    <h4 class="sub-titulo">Assinatura autorizado:</h4>
    <p class="dados">{{$responsa_auto->assinatura_autorizado}}</p>
    <hr>
  </div>

</div>






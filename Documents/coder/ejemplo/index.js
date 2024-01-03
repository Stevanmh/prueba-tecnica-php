const express = require('express');
const app = express();

// Ruta de prueba
app.get('/api/user', (req, res) => {
  res.json({mensaje:'¡Hola, mundo! Esta es una prueba de Express con nodemon.'});
});

app.get('/api/productos',(req,res)=>{
  if(Object.entries(req.query).length > 0){
    res.json({
      result: 'obtiene una query',
      query: req.query
    })
  }
  else{
    res.json({
      result: 'no obtiene una query',
    })
  }
})

// Iniciar el servidor en el puerto 3000
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Servidor Express escuchando en el puerto ${PORT}`);
});

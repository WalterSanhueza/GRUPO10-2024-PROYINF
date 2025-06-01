import unittest
import requests

# Usuarios válidos que deberían existir en la base de datos
usuarios_validos = [
    {'correo': 'javier@javier.javier', 'contraseña': 'diego'},
    {'correo': 'walter.sanhueza@fia.cl', 'contraseña': 'contraseña3'},
    {'correo': 'ana.gomez@example.com', 'contraseña': 'contraseña2'},
    {'correo': 'walter.sanhueza@usm.cl', 'contraseña': 'fdasfdasfadsf'},
    {'correo': 'Maca.pozos@fia.cl', 'contraseña': 'contraseña4'},
    {'correo': 'minis.terio@minAgri.com', 'contraseña': 'contraseña1'}
]

# Usuarios inválidos que no deberían poder iniciar sesión
usuarios_invalidos = [
    {'correo': 'inexistente@correo.com', 'contraseña': 'incorrecta'},
    {'correo': 'javier@javier.javier', 'contraseña': 'malacontraseña'},
    {'correo': '43241@usm.cl', 'contraseña': 'diego'},
    {'correo': 'ana.gomez@example.com', 'contraseña': 'diego'},
    {'correo': '12321@gmail.com', 'contraseña': 'diego'}
]

usuarios_vacios = [
    {'correo': '', 'contraseña': 'diego'},
    {'correo': 'ana.gomez@example.com', 'contraseña': ''},
    {'correo': '', 'contraseña': ''}
]



class TestLoginUsuarioPHP(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        cls.url = "http://localhost/hito2_2025/validar.php"

    def test_login_valido(self):
        for usuario in usuarios_validos:
            print(f"Probando registro de usuarios validos: {usuario}")
            with self.subTest(usuario=usuario):
                response = requests.post(self.url, data=usuario)
                self.assertEqual(response.status_code, 200)
                self.assertIn("Sesión iniciada correctamente", response.text)

    def test_login_invalido(self):
        for usuario in usuarios_invalidos:
            print(f"Probando registro de usuarios invalidos: {usuario}")
            with self.subTest(usuario=usuario):
                response = requests.post(self.url, data=usuario)
                self.assertEqual(response.status_code, 200)
                self.assertIn("Cuenta inexistente", response.text)

    def test_login_campos_vacios(self):
        for usuario in usuarios_vacios:
            print(f"Probando registro de usuarios con campos vacios: {usuario}")
            with self.subTest(usuario=usuario):
                response = requests.post(self.url, data=usuario)
                self.assertEqual(response.status_code, 200)
                self.assertIn("Debe llenar todos los campos", response.text)


if __name__ == "__main__":
    unittest.main()

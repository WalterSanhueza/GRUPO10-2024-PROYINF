import unittest
import requests
import random

# Usuarios ya registrados en la base de datos
usuarios_existentes = [
    {'correo': 'javier@javier.javier', 'nombres': 'javier', 'rut': '00000000-0', 'contraseña': 'diego', 'envios': 0},
    {'correo': 'walter.sanhueza@fia.cl', 'nombres': 'Walter Sanhueza','rut': '202023564-3', 'contraseña': 'contraseña3', 'envios': 1},
    {'correo': 'ana.gomez@example.com', 'nombres': 'Ana Gomez','rut': '23456789', 'contraseña': 'contraseña2', 'envios': 0},
    {'correo': 'walter.sanhueza@usm.cl', 'nombres': 'walter','rut': '321312132-7', 'contraseña': 'fdasfdasfadsf', 'envios': 0},
    {'correo': 'Maca.pozos@fia.cl', 'nombres': 'Macarena del Pozo','rut': '45678901', 'contraseña': 'contraseña4', 'envios': 1},
    { 'correo': 'minis.terio@minAgri.com', 'nombres': 'Ministerio de agricultura','rut': '77.777.888-9', 'contraseña': 'contraseña1', 'envios': 1}
]

# 6 usuarios nuevos para probar registros exitosos
usuarios_nuevos = [
    {'correo': f'nuevo{i}@correo.com', 'nombres': f'Usuario{i}', 'rut': f'11111-{i}', 'contraseña': f'clave{i}', 'envios': random.choice([0, 1])}
    for i in range(6)
]

usuarios_vacios = [
    {"correo": "javier@javier.javier","nombres": "","rut": "","contraseña": "","envios": ""},
    {"correo": "","nombres": "Walter","rut": "","contraseña": "","envios": ""},
    {"correo": "","nombres": "","rut": "00000000-0","contraseña": "","envios": ""},
    {"correo": "","nombres": "","rut": "","contraseña": "contraseña3","envios": ""},
    {"correo": "","nombres": "","rut": "","contraseña": "","envios": "1"},
    {"correo": "","nombres": "","rut": "","contraseña": "","envios": ""}
]


class TestRegistroUsuarioPHP(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        cls.url = "http://localhost/hito2_2025/cc.php"

    def test_registros_validos(self):
        for usuario in usuarios_nuevos:
            print(f"Probando registro de usuarios nuevos: {usuario}")
            with self.subTest(usuario=usuario):
                response = requests.post(self.url, data=usuario)
                self.assertEqual(response.status_code, 200)
                self.assertIn("Usuario creado exitosamente.", response.text)

    def test_registros_invalidos(self):
        for usuario in usuarios_existentes:
            print(f"Probando registro de usuarios ya existentes: {usuario}")
            with self.subTest(usuario=usuario):
                response = requests.post(self.url, data=usuario)
                self.assertEqual(response.status_code, 200)
                self.assertIn("Error: el usuario ya existe", response.text)

    def test_registro_campos_vacios(self):
        for usuario in usuarios_vacios:
            print(f"Probando registro de usuarios con campos vacios: {usuario}")
            with self.subTest(usuario=usuario):
                response = requests.post(self.url, data=usuario)
                self.assertEqual(response.status_code, 200)
                self.assertIn("Debe llenar todos los campos", response.text)

if __name__ == "__main__":
    unittest.main()

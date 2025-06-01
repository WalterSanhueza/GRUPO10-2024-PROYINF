import unittest
import requests

# correos ya registrados en la base de datos
correosNoEnviar = [
    {'correo': 'javier@javier.javier', 'envios': 0},
    {'correo': 'walter.sanhueza@fia.cl', 'envios': 0},
    {'correo': 'ana.gomez@example.com', 'envios': 0},
    {'correo': 'walter.sanhueza@usm.cl',  'envios': 0},
    {'correo': 'Maca.pozos@fia.cl',  'envios': 0},
    { 'correo': 'minis.terio@minAgri.com',  'envios': 0}
]


correosEnviar = [
    {'correo': 'javier@javier.javier', 'envios': 1},
    {'correo': 'walter.sanhueza@fia.cl', 'envios': 1},
    {'correo': 'ana.gomez@example.com', 'envios': 1},
    {'correo': 'walter.sanhueza@usm.cl',  'envios': 1},
    {'correo': 'Maca.pozos@fia.cl',  'envios': 1},
    { 'correo': 'minis.terio@minAgri.com',  'envios': 1}
]


class TestRegistrocorreoPHP(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        cls.url = "http://localhost/hito2_2025/mc.php"

    def test_correos_NoEnviar(self):
        for correo in correosNoEnviar:
            print(f"Probando registro de correos ya existentes: {correo}")
            with self.subTest(correo=correo):
                response = requests.post(self.url, data=correo)
                self.assertEqual(response.status_code, 200)
                self.assertIn("No se ha enviado el boletín", response.text)

    def test_correos_enviar(self):
        for correo in correosEnviar:
            print(f"Probando registro de correos vacios: {correo}")
            with self.subTest(correo=correo):
                response = requests.post(self.url, data=correo)
                self.assertEqual(response.status_code, 200)
                self.assertIn("Boletín enviado a: " + correo['correo'], response.text)

if __name__ == "__main__":
    unittest.main()

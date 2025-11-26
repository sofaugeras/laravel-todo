import requests
import time

URL = "http://localhost:8000/login"  # adapte si besoin (port, domaine, etc.)

for i in range(1, 16):  # 15 requêtes
    response = requests.get(URL)
    print(f"Requête {i}: status = {response.status_code}")

    # Affiche quelques headers utiles si présents
    print("  X-RateLimit-Limit     :", response.headers.get("X-RateLimit-Limit"))
    print("  X-RateLimit-Remaining :", response.headers.get("X-RateLimit-Remaining"))
    print("  Retry-After           :", response.headers.get("Retry-After"))
    print("-" * 40)

    # On attend très peu pour rester dans la même minute
    time.sleep(1)  # 2 secondes entre chaque requête

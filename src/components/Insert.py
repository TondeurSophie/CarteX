import mysql.connector
import requests
import re
import random  # Ajoutez cette ligne pour utiliser la bibliothèque random

def remove_special_characters(text):
    return re.sub(r'[^\x00-\x7F]+', '', text)

# connection à la base de donnée
try:
    db = mysql.connector.connect(
        host="localhost",
        user="root",
        password="password",
        database="carteX"
    )
    
    cursor = db.cursor()

# connexion à l'API
    api_url = "https://db.ygoprodeck.com/api/v7/cardinfo.php"
    response = requests.get(api_url)

    if response.status_code == 200:
        data = response.json().get("data", [])

        # Mélanger la liste de cartes de manière aléatoire
        random.shuffle(data)

        # Limiter à 300 cartes
        for index, card in enumerate(data[:300]):  # Utilisez la liste mélangée
            card_id = card.get("id", "N/A")
            card_name = remove_special_characters(card.get("name", "N/A"))
            card_type = remove_special_characters(card.get("type", "N/A"))
            frame_type = remove_special_characters(card.get("frameType", "N/A"))
            card_description = remove_special_characters(card.get("desc", "N/A"))
            card_race = remove_special_characters(card.get("race", "N/A"))
            archetype = remove_special_characters(card.get("archetype", "N/A"))
            ygoprodeck_url = card.get("ygoprodeck_url", "N/A")

            card_prices = card.get("card_prices", [])
            cardmarket_price = next((p.get("cardmarket_price", "N/A") for p in card_prices), "N/A")

            card_sets = card.get("card_sets", [])
            card_sets_info = ", ".join([f"{set_info['set_name']} ({set_info['set_rarity']})" for set_info in card_sets])

            card_images = card.get("card_images", [])
            card_image_url = card_images[0].get("image_url", "N/A")

            insert_query = "INSERT INTO cartes (id, name, type, frameType, description, race, archetype, ygoprodeck_url, cards_sets, cards_images, cards_price) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
            values = (card_id, card_name, card_type, frame_type, card_description, card_race, archetype, ygoprodeck_url, card_sets_info, card_image_url, cardmarket_price)
            cursor.execute(insert_query, values)

        db.commit()
        print("Données insérées avec succès dans la base de données.")

except mysql.connector.Error as err:
    print("Une erreur MySQL s'est produite:", err)

finally:
    if 'db' in locals() and db.is_connected():
        cursor.close()
        db.close()
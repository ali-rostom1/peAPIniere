# 🌱 API de Gestion de Pépinière - Readme  

## 📌 Aperçu du Projet  
Cette API est conçue pour optimiser la gestion des stocks et des ventes d'une pépinière en croissance, en améliorant l'efficacité opérationnelle et l'expérience client. Elle inclut des fonctionnalités d'authentification, de gestion des plantes et catégories, de traitement des commandes et d'analytique.  

## 🎯 Fonctionnalités Principales  
### **Clients**  
- 🔐 Inscription & connexion avec authentification JWT  
- 🪴 Consulter les plantes (nom, description, prix, images, catégorie)  
- 🧺 Passer des commandes en sélectionnant des plantes (via leurs slugs) et quantités  
- 🆗 Suivre l'état des commandes (*En attente*, *En préparation*, *Livrée*)  
- ❌ Annuler une commande avant sa préparation  

### **Employés**  
- 🪪 Connexion avec permissions basées sur les rôles  
- ⌛ Mettre à jour l'état des commandes (ex. : "Prête pour livraison")  

### **Administrateurs**  
- 📊 Voir les statistiques de ventes (plantes populaires, répartition par catégorie)  
- 🎍 Gérer les plantes/catégories (CRUD)  
- 🖼️ Uploader des images (max 4 par plante)  

### **Développeurs**  
- ✅ Tests unitaires (authentification, catégories, slugs)  
- 📄 Documentation API (Swagger/OpenAPI)  
- 🛡️ DTOs pour la validation des données  
- 💾 Pattern DAO pour les interactions avec la base de données  
- � Docker en bonus  

---  
## 🛠️ Stack Technique  
- **Backend** : Laravel (Query Builder, Spatie Sluggable)  
- **Auth** : JWT  
- **Tests** : pest + Postman  
- **Bonus** : Docker  

---  
## 📂 Endpoints (Exemples)  
- `GET /api/plants/basilic-aromatique` → Détails d'une plante par slug  
- `POST /api/orders` → Soumettre une nouvelle commande  
- `GET /admin/stats` → Statistiques de ventes (réservé aux admins)  

---  
## 🚀 Installation  
1. Cloner le dépôt  
2. Installer les dépendances : `composer install`  
3. Configurer `.env` (DB, JWT, etc.)  
4. Lancer les migrations : `php artisan migrate`  
5. Démarrer le serveur : `php artisan serve`  

### **Liens utiles**  
- [Lien de Presentation](https://www.canva.com/design/DAGjDlGHX8c/MHO7sk_oQxFu_9P64k-tWA/edit?utm_content=DAGjDlGHX8c&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton)
- [Lien de Plannification](https://github.com/users/ali-rostom1/projects/14)

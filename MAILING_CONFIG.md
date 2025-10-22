# 📧 Configuration Mailing - EcoEvents

## ✅ Configuration Actuelle (Mode LOG - Développement)

### Ce qui a été fait automatiquement :

1. ✅ **AuthController mis à jour** - L'envoi d'email est maintenant activé
2. ✅ **Mode LOG configuré** - Les emails sont sauvegardés dans les logs
3. ✅ **Script PowerShell créé** - Pour lire facilement les emails
4. ✅ **Page Admin créée** - Interface web pour voir les emails
5. ✅ **Routes ajoutées** - `/admin/email-logs`

---

## 🎯 Comment Tester Maintenant

### Méthode 1 : Via l'Interface Web Admin (Recommandée)

1. **Connectez-vous en tant qu'admin**
   ```
   http://127.0.0.1:8004/login
   Email: admin@admin.com
   ```

2. **Allez sur la page des logs emails**
   ```
   http://127.0.0.1:8004/admin/email-logs
   ```

3. **Testez "Mot de passe oublié"**
   - Ouvrez dans un nouvel onglet : `http://127.0.0.1:8004/forgot-password`
   - Entrez : `admin@admin.com`
   - Cliquez : "Envoyer le lien"

4. **Retournez sur la page admin**
   - La page se rafraîchit automatiquement toutes les 15 secondes
   - Ou cliquez sur "Actualiser"
   - Le lien de réinitialisation apparaîtra
   - Cliquez sur "Ouvrir" pour tester

---

### Méthode 2 : Via le Script PowerShell

1. **Exécutez le script**
   ```powershell
   .\show-reset-emails.ps1
   ```

2. **Le script va:**
   - Afficher tous les liens trouvés
   - Copier le dernier lien dans le presse-papiers
   - Vous proposer de l'ouvrir automatiquement

---

### Méthode 3 : Manuellement dans le Fichier Log

1. **Ouvrez le fichier log**
   ```
   code storage/logs/laravel.log
   ```

2. **Cherchez** (Ctrl+F) : `reset-password`

3. **Copiez l'URL** qui ressemble à :
   ```
   http://127.0.0.1:8004/reset-password/abc123...?email=admin%40admin.com
   ```

---

## 🔧 Configuration des Emails (`.env`)

### Configuration Actuelle (Mode LOG - Développement)

```env
MAIL_MAILER=log                          # Mode LOG actif
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="Balsem.khouni@esprit.tn"
MAIL_FROM_NAME="Laravel"
```

✅ **Avantages du Mode LOG:**
- Aucune configuration externe nécessaire
- Fonctionne immédiatement
- Gratuit et simple
- Parfait pour le développement

---

## 🚀 Options pour la Production

### Option 1 : MailHog (Local - Recommandé pour dev)

**Avantages:** Interface web, 100% local, aucun compte

```powershell
# Installer avec Docker
docker run -d -p 1025:1025 -p 8025:8025 mailhog/mailhog
```

**Modifier `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_ENCRYPTION=null
```

**Voir les emails:** `http://localhost:8025`

---

### Option 2 : Mailtrap (Cloud - Gratuit)

**Avantages:** Interface professionnelle, 500 emails/mois gratuits

1. Inscrivez-vous sur https://mailtrap.io
2. Créez une inbox
3. Copiez les credentials

**Modifier `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=votre_username_mailtrap
MAIL_PASSWORD=votre_password_mailtrap
MAIL_ENCRYPTION=tls
```

---

### Option 3 : Gmail (Production)

**Avantages:** Emails réels envoyés, 500/jour gratuit

1. Créez un App Password Google :
   - Compte Google → Sécurité → Validation en deux étapes
   - Mots de passe d'application → Générer

**Modifier `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=Balsem.khouni@esprit.tn
MAIL_PASSWORD=votre_app_password_google
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="Balsem.khouni@esprit.tn"
MAIL_FROM_NAME="EcoEvents"
```

---

## 📁 Fichiers Créés/Modifiés

### Fichiers Modifiés:
- ✅ `app/Http/Controllers/AuthController.php` - Envoi d'email activé
- ✅ `routes/web.php` - Routes email-logs ajoutées
- ✅ `.env` - Configuration email (déjà configurée)

### Fichiers Créés:
- ✅ `show-reset-emails.ps1` - Script PowerShell
- ✅ `app/Http/Controllers/Admin/EmailLogController.php` - Contrôleur admin
- ✅ `resources/views/admin/email-logs.blade.php` - Page admin
- ✅ `MAILING_CONFIG.md` - Ce fichier (documentation)

---

## 🧪 Test Complet

### 1. Demander une réinitialisation
```
URL: http://127.0.0.1:8004/forgot-password
Email: admin@admin.com
```

### 2. Voir l'email (Choisissez une méthode)

**A. Interface Admin:**
```
http://127.0.0.1:8004/admin/email-logs
```

**B. Script PowerShell:**
```powershell
.\show-reset-emails.ps1
```

**C. Fichier log directement:**
```powershell
code storage/logs/laravel.log
```

### 3. Cliquer sur le lien de réinitialisation

### 4. Remplir le formulaire
```
Email: admin@admin.com (pré-rempli)
Nouveau mot de passe: nouveaupassword123
Confirmation: nouveaupassword123
```

### 5. Se connecter avec le nouveau mot de passe
```
http://127.0.0.1:8004/login
Email: admin@admin.com
Mot de passe: nouveaupassword123
```

---

## 🔄 Après Changement de Configuration

Après avoir modifié `.env`, exécutez toujours :

```powershell
php artisan config:clear
php artisan serve --port=8004
```

---

## ❓ FAQ

### Q: Les emails sont-ils réellement envoyés?
**R:** Non, en mode LOG ils sont seulement enregistrés dans le fichier log.

### Q: Comment passer en mode production?
**R:** Choisissez une des options ci-dessus (MailHog, Mailtrap, ou Gmail) et modifiez `.env`

### Q: Où voir les emails en mode LOG?
**R:** 3 façons:
- Interface admin: `/admin/email-logs`
- Script: `.\show-reset-emails.ps1`
- Fichier: `storage/logs/laravel.log`

### Q: Le lien expire après combien de temps?
**R:** 60 minutes (configurable dans `AuthController`)

### Q: Puis-je tester sans configuration externe?
**R:** Oui ! Le mode LOG actuel fonctionne sans rien installer.

---

## 📞 Support

Si vous avez des questions ou besoin d'aide pour configurer une autre méthode d'envoi d'emails, contactez votre développeur.

---

**✅ Configuration terminée et fonctionnelle !**

Tout est prêt pour le développement. Testez maintenant avec la méthode 1 (Interface Admin).

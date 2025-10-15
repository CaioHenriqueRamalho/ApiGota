# 🩺 API Receita

**API Receita** é uma API em PHP desenvolvida para **ler QR Codes** presentes em receituários médicos e **validar sua autenticidade**.  
A partir da leitura do QR Code, o sistema identifica se o receituário é válido e retorna informações como:

- 🏥 Nome da **instituição de saúde**  
- 👨‍⚕️ Nome do **médico responsável**  
- 🔢 **CRM** do médico  

---

## 🚀 Funcionalidades

- 📷 Leitura e decodificação de QR Codes (imagem ou base64)  
- ✅ Validação de receituário médico digital  
- 🏥 Retorno de dados da instituição e do médico  
- ⚙️ API REST simples, leve e fácil de integrar  

---

## 🧩 Fluxo de Funcionamento

1. O cliente envia uma imagem contendo o **QR Code** via requisição `POST`.
2. A API faz a leitura e decodificação do QR Code.
3. O conteúdo é verificado em uma base de dados (ou serviço externo).
4. A API retorna um JSON com o resultado da validação.

---

## 💡 Exemplo de Resposta

### ✅ Receituário válido

```json
{
  "status": "válido",
  "instituicao": "Hospital São Lucas",
  "medico": {
    "nome": "Dr. João Silva",
    "crm": "CRM-SP 123456"
  },
  "mensagem": "Receituário validado com sucesso."
}

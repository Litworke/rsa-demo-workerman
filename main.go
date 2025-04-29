package main

import (
	"crypto/rand"
	"crypto/rsa"
	"crypto/x509"
	"encoding/pem"
	"errors"
	"fmt"
)

func main() {
	// 公钥数据，通常从文件中读取
	pubKey := `-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAsVt0HClSaWejWSCkTK0l
cCNAJNMdpScwnKO5OkDWkRXqkGDjJTLL+6ba+/r1i+fQgkaGGXzhE0/Nr7bNp/1o
+LNYELZP6NHGIw8P5zNTc6Rhc8tZRgT1Urb3XU2ywBhQyH6+MsI7ZaBDir7Nnqsi
E9J2DrlKWiP5BTxfD0bSEVTYp/qxBPydFXHNNJwdWNc4V0EsRWTtp40msO+tuYA4
boRQLE0io/8YQDpNNPiMHY5Pmt/uF0l5k16D2Z8pXoSF3PslPpX4NUMDXXjB+Ef7
1+aWwN0KXJro/rBNGZOHGNNggSFrC30kWjJoXaPzBQoogDXF5Dpu1jSx8sDgKJf7
so1Sq082O2CW+JvB3+yLHO56gAltXSjaeyO/xgSC4QuGk/80hHHkp9wJTXo7Lh9+
xyfGKdn8LwXX7gf4o0JHLoeKWlJ7Wef53+f1T6IwbgHWFXv69u8P3x5GO/UtygBZ
aeebCW+2xGd/C2aIVTTYZT7cJchSyvAn3ym/tF9lenqa8dRyHButRgP9xZRoS9aA
xxbhLhl/agn+WJDhCi0vCAWjhf5YDOcPdUi1ZdgCrqiBK+u3WN6pH+MskSu2YFf7
KD4OnNnV2Tdv0g7rWOeffRhyUziu287u7hIzszQU2Cm4NwIefWJFZaE86DcVhJWj
72EDTcOtnlGgA51J1KWPK30CAwEAAQ==
-----END PUBLIC KEY-----`

	// 需要加密的数据
	data := []byte("Hello, RSA!")

	// 解析公钥
	pub, err := parsePublicKey([]byte(pubKey))
	if err != nil {
		fmt.Println("解析公钥失败:", err)
		return
	}

	// 使用公钥加密数据
	encryptedData, err := rsa.EncryptPKCS1v15(rand.Reader, pub, data)
	if err != nil {
		fmt.Println("加密失败:", err)
		return
	}

	// 输出加密结果
	fmt.Printf("加密数据: %x\n", encryptedData)
}

// parsePublicKey 解析公钥
func parsePublicKey(pubPEM []byte) (*rsa.PublicKey, error) {
	block, _ := pem.Decode(pubPEM)
	if block == nil {
		return nil, errors.New("公钥数据不存在")
	}
	pub, err := x509.ParsePKIXPublicKey(block.Bytes)
	if err != nil {
		return nil, err
	}

	switch pub := pub.(type) {
	case *rsa.PublicKey:
		return pub, nil
	default:
		return nil, errors.New("公钥不是RSA类型")
	}
}
